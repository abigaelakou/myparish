<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nouvelle;
use App\Models\Annonce;
use Illuminate\Support\Facades\Auth;

class AccueilApiController extends Controller
{
    /**
     * Retourne les dernières nouvelles et les annonces de la semaine
     */
    public function accueil()
    {
        $user = Auth::user();

        // Récupérer les dernières nouvelles pour la paroisse de l'utilisateur (limitées à 5 par exemple)
        $nouvelles = Nouvelle::where('paroisse_id', $user->paroisse_id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Récupérer les annonces récentes (par exemple de cette semaine uniquement)
        $annonces = Annonce::where('paroisse_id', $user->paroisse_id)
            ->whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        // Réponse JSON structurée
        return response()->json([
            'status' => true,
            'message' => 'Contenu de l\'accueil récupéré avec succès.',
            'nouvelles' => $nouvelles,
            'annonces' => $annonces
        ]);
    }
}
