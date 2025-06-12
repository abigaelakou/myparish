<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evenement;
use Illuminate\Support\Facades\Auth;

class EvenementController extends Controller
{
    /**
     * Retourne les événements à venir pour la paroisse de l'utilisateur
     */
    public function evenementsAvenir()
    {
        $user = Auth::user();

        // Récupère les événements dont la date est aujourd'hui ou dans le futur
        $evenements = Evenement::where('paroisse_id', $user->paroisse_id)
            ->whereDate('date_evement', '>=', now()->toDateString())
            ->orderBy('date_evement', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Événements à venir récupérés avec succès.',
            'evenements' => $evenements
        ]);
    }
}
