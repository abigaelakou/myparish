<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Messe;

class MesseApiController extends Controller
{
    /**
     * Récupérer les demandes de messe de l'utilisateur connecté
     */
    public function mesDemandesDeMesse()
    {
        $user = Auth::user();

        $messes = Messe::where('id_user', $user->id)
            ->where('paroisse_id', $user->paroisse_id)
            ->orderBy('date_messe', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Liste des demandes de messe récupérée avec succès.',
            'messes' => $messes
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
            'intentions' => 'required|string'
        ]);

        $user = Auth::user();

        $messe = Messe::create([
            'id_user' => $user->id,
            'id_type_messe' => $request->id_type_messe,
            'id_type_intention' => $request->id_type_intention,
            'date_messe' => $request->date_messe,
            'heure_messe' => $request->heure_messe,
            'lieu_messe' => $request->lieu_messe,
            'intentions' => $request->intentions,
            'paroisse_id' => $user->paroisse_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Demande de messe enregistrée avec succès.',
            'messe' => $messe
        ]);
    }
}
