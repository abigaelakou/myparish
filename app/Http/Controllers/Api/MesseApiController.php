<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DemandeMesse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Messe;
use App\Models\paiement;
use App\Models\Transaction;

class MesseApiController extends Controller
{
    /**
     * Récupérer les demandes de messe de l'utilisateur connecté
     */
public function mesDemandesDeMesse()
{
    $user = Auth::user();

    $messes = DemandeMesse::with(['typeMesse', 'typeIntention'])
        ->where('id_user', $user->id)
        ->where('paroisse_id', $user->paroisse_id)
        ->orderBy('date_messe', 'desc')
        ->get();

    $data = $messes->map(function($messe) {
        return [
            'id' => $messe->id,
            'lib_type_messe' => $messe->typeMesse->lib_type_messe ?? 'Type inconnu',
            'lib_type_intention' => $messe->typeIntention->lib_type_intention ?? 'Intention inconnue',
            'date_messe' => $messe->date_messe,
            'heure_messe' => $messe->heure_messe,
            'lieu_messe' => $messe->lieu_messe,
            'intentions' => $messe->intentions,
        ];
    });

    return response()->json([
        'status' => true,
        'message' => 'Liste des demandes de messe récupérée avec succès.',
        'messes' => $data
    ]);
}


    /**
     * Créer une nouvelle demande de messe
     */
public function demanderMesse(Request $request)
{
    $request->validate([
        'id_type_messe' => 'required|exists:type_messes,id',
        'id_type_intention' => 'required|exists:type_intentions,id',
        'date_messe' => 'required|date',
        'heure_messe' => 'required|string',
        'lieu_messe' => 'required|string',
        'intentions' => 'required|string',
        'montant' => 'required|numeric',
        'moyen_paiement' => 'required|string',
        'contact' => 'required|string',
        'transaction_id' => 'nullable|string',
    ]);

    $user = Auth::user();

    // 1. Enregistrement de la demande
    $messe = DemandeMesse::create([
        'id_user' => $user->id,
        'id_type_messe' => $request->id_type_messe,
        'id_type_intention' => $request->id_type_intention,
        'date_messe' => $request->date_messe,
        'heure_messe' => $request->heure_messe,
        'lieu_messe' => $request->lieu_messe,
        'intentions' => $request->intentions,
        'paroisse_id' => $user->paroisse_id,
    ]);

    // 2. Paiement lié à la demande — stocké dans $paiement
    $paiement = paiement::create([
        'id_demande' => $messe->id,
        'moyen_paiement' => $request->moyen_paiement,
        'montant' => $request->montant,
        'contact' => $request->contact,
        'paroisse_id' => $user->paroisse_id,
    ]);

    // 3. Traçabilité (si transaction_id fourni)
    if ($request->transaction_id) {
        Transaction::create([
            'source_id' => $messe->id,
            'source_type' => 'messe',
            'transaction_id' => $request->transaction_id,
            'paroisse_id' => $user->paroisse_id,
            'montant' => $request->montant,
            'status' => 'en attente',
            'paiement_id' => $paiement->id, 
            'date' => now(),
        ]);
    }

    return response()->json([
        'status' => true,
        'message' => 'Demande de messe enregistrée avec succès.',
        'messe' => $messe
    ]);
}



}
