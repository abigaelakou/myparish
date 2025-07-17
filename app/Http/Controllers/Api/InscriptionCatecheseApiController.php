<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inscription;
use App\Models\PaiementCatechese;
use App\Models\RecuPaiement;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

class InscriptionCatecheseApiController extends Controller
{
    public function store(Request $request)
    {
        // Validation des données reçues
        $validator = Validator::make($request->all(), [
            'annee_catechetique' => 'required|string',
            'date_inscription' => 'required|date',
            'id_catechumene' => 'required|exists:catechumenes,id',
            'id_niveau' => 'required|exists:niveau_catechetiques,id',
            'id_session' => 'required|exists:session_catecheses,id',
        ]);

        // Si la validation échoue, retourner les erreurs
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 400);
        }

        // Créer une nouvelle inscription
        $inscription = Inscription::create([
            'annee_catechetique' => $request->annee_catechetique,
            'date_inscription' => $request->date_inscription,
            'id_catechumene' => $request->id_catechumene,
            'id_user' => Auth::id(),
            'id_niveau' => $request->id_niveau,
            'id_session' => $request->id_session,
            'paroisse_id' => auth()->user()->paroisse_id, // Assurez-vous que l'utilisateur est authentifié
        ]);

        // Créer un paiement avec statut "En attente"
        PaiementCatechese::create([
            'id_inscription' => $inscription->id,
            'montant' => 0, // Montant initial
            'contact' => null, // Contact sera ajouté plus tard
            'mode_paiement' => null, // Mode de paiement sera choisi lors du paiement
            'payment_status' => 'En attente',
        ]);

        // Retourner la réponse avec les détails de l'inscription
        return response()->json([
            'message' => 'Inscription effectuée avec succès.',
            'inscription' => $inscription
        ], 201);
    }

    public function getPaiementInfo($id)
{
    // Vérifie que l'inscription existe
    $inscription = Inscription::with(['catechumene', 'niveau', 'session', 'paiement'])->find($id);

    if (!$inscription) {
        return response()->json([
            'error' => 'Inscription non trouvée.'
        ], 404);
    }

        return response()->json([
            'id' => $inscription->id,
            'annee_catechetique' => $inscription->annee_catechetique,
            'date_inscription' => $inscription->date_inscription,
            'id_catechumene' => $inscription->id_catechumene,
            'id_user' => $inscription->id_user,
            'id_niveau' => $inscription->id_niveau,
            'id_session' => $inscription->id_session,
            'paroisse_id' => $inscription->paroisse_id,

            // Relations sécurisées
            'nom_catechumene' => optional($inscription->catechumene)->name,

            'contact' => optional($inscription->catechumene)->contact,
            'email' => optional($inscription->catechumene)->email,
            'nom_prenom_pere' => optional($inscription->catechumene)->nom_prenom_pere,
            'contact_pere' => optional($inscription->catechumene)->contact_pere,
            'nom_prenom_mere' => optional($inscription->catechumene)->nom_prenom_mere,
            'contact_mere' => optional($inscription->catechumene)->contact_mere,
            'nom_prenom_parain' => optional($inscription->catechumene)->nom_prenom_parain,
            'contact_parain' => optional($inscription->catechumene)->contact_parain,
            'sacrement_recu' => optional($inscription->catechumene)->sacrement_recu,

            'lib_niveau' => optional($inscription->niveau)->lib_niveau,
            'lib_session_catechese' => optional($inscription->session)->lib_session_catechese,

            'montant' => optional($inscription->paiement)->montant ?? 0,
            'payment_status' => optional($inscription->paiement)->payment_status ?? 'En attente',
            'mode_paiement' => optional($inscription->paiement)->mode_paiement,
            'contact_paiement' => optional($inscription->paiement)->contact,
        ]);


}

public function payerInscription(Request $request)
{
    $request->validate([
        'id_inscription' => 'required|exists:inscriptions,id',
        'montant' => 'required|numeric|min:1',
        'mode_paiement' => 'required|string',
        'contact' => 'nullable|string',
        'payment_status' => 'required|string|in:En attente,Payé'
    ]);

    // Vérifie si un paiement existe déjà pour cette inscription
    $paiement = PaiementCatechese::where('id_inscription', $request->id_inscription)->first();

    if ($paiement) {
        $paiement->update([
            'montant' => $request->montant,
            'mode_paiement' => $request->mode_paiement,
            'contact' => $request->contact,
            'payment_status' => $request->payment_status,
            'paroisse_id' => auth()->user()->paroisse_id,
        ]);
    } else {
        $paiement = PaiementCatechese::create([
            'id_inscription' => $request->id_inscription,
            'montant' => $request->montant,
            'mode_paiement' => $request->mode_paiement,
            'contact' => $request->contact,
            'payment_status' => $request->payment_status,
            'paroisse_id' => auth()->user()->paroisse_id,
        ]);

        // Créer une entrée dans la table transactions
        Transaction::create([
            'source_id' => $paiement->id_inscription,          // identifiant de l'inscription
            'source_type' => 'catechese',                      // identifiant logique pour le type
            'transaction_id' => 'TXN' . uniqid(),              // ID transaction généré (si pas fourni par un prestataire)
            'paroisse_id' => auth()->user()->paroisse_id,
            'montant' => $paiement->montant,
            'status' => $paiement->payment_status,
            'paiement_id' => $paiement->id,
            'date' => now(),
        ]);
    }

    // Charger les relations
    $paiement->load('inscription.catechumene', 'inscription.niveau', 'inscription.session');
// Récupérer les données nécessaires
    $inscription = $paiement->inscription;
    $catéchumène = $inscription->catechumene ?? null;

    $recu = RecuPaiement::firstOrCreate(
    ['id_paiement' => $paiement->id],
    [
        'nom_prenom' => $catéchumène?->name ?? 'Inconnu',
        'montant' => $paiement->montant,
        'contact' => $paiement->contact,
        'date_paiement' => $paiement->date_paiement ?? now(),
        'paroisse_id' => auth()->user()->paroisse_id,
    ]
);

    // Générer le PDF
    // $pdf = FacadePdf::loadView('pdf.recu_catechese', ['recu' => $paiement]);
    $pdf = FacadePdf::loadView('Espaces.Catechese.recu_paiement', ['recu' => $recu]);

    // Nom du fichier
    $filename = 'recu_inscription_' . $paiement->id . '.pdf';

    // Enregistrer le fichier
    Storage::put("public/recus/$filename", $pdf->output());

    // Lien public
    $url = asset("storage/recus/$filename");

    return response()->json([
        'message' => 'Paiement enregistré avec succès.',
        'recu_url' => $url,
    ], 201);
}

public function listePaiements()
{
    $paiements = PaiementCatechese::with([
            'inscription.catechumene',
            'inscription.niveau',
            'inscription.session',
        ])
        ->whereHas('inscription', function ($q) {
            $q->where('paroisse_id', auth()->user()->paroisse_id);
        })
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'paiements' => $paiements,
    ]);
}




}
