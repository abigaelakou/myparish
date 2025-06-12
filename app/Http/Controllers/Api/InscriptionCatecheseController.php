<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inscription;
use App\Models\PaiementCatechese;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InscriptionCatecheseController extends Controller
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
        'inscription_id' => $inscription->id,
        'date_inscription' => $inscription->date_inscription,
        'annee_catechetique' => $inscription->annee_catechetique,
        'catéchumène' => $inscription->catechumene->nom ?? null,
        'niveau' => $inscription->niveau->lib_niveau ?? null,
        'session' => $inscription->session->lib_session ?? null,
        'paiement' => [
            'montant' => $inscription->paiement->montant ?? 0,
            'status' => $inscription->paiement->payment_status ?? 'Non défini',
            'mode_paiement' => $inscription->paiement->mode_paiement ?? null,
            'contact' => $inscription->paiement->contact ?? null,
        ]
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
        ]);
    } else {
        $paiement = PaiementCatechese::create([
            'id_inscription' => $request->id_inscription,
            'montant' => $request->montant,
            'mode_paiement' => $request->mode_paiement,
            'contact' => $request->contact,
            'payment_status' => $request->payment_status,
        ]);
    }

    // Charger les relations
    $paiement->load('inscription.catechumene', 'inscription.niveau', 'inscription.session');

    // Générer le PDF
    $pdf = FacadePdf::loadView('pdf.recu_catechese', ['recu' => $paiement]);

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
    $paiements = PaiementCatechese::with('inscription')
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'paiements' => $paiements
    ]);
}


}
