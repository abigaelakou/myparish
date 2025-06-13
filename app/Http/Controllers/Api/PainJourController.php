<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PainJour;
use Illuminate\Support\Facades\Auth;

class PainJourController extends Controller
{
    /**
     * Récupérer le pain du jour pour l'utilisateur connecté
     */
    public function painDuJour()
    {
        $user = Auth::user();

        $pain = PainJour::where('paroisse_id', $user->paroisse_id)
            ->where('date_pain', now()->toDateString())
            ->first();

        if (!$pain) {
            return response()->json([
                'status' => false,
                'message' => 'Aucun pain du jour disponible pour aujourd’hui.'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Pain du jour récupéré avec succès.',
            'pain' => $pain
        ]);
    }

    /**
     * (Optionnel) Liste des derniers pains
     */
    public function derniersPains()
    {
        $user = Auth::user();

        $pains = PainJour::where('paroisse_id', $user->paroisse_id)
            ->orderByDesc('date_pain')
            ->take(7)
            ->get();

        return response()->json([
            'status' => true,
            'pains' => $pains
        ]);
    }
}
