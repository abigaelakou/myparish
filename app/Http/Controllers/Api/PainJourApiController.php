<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PainJour;
use Illuminate\Support\Facades\Auth;

class PainJourApiController extends Controller
{
   public function painDuJourUtilisateur()
{
    $today = now()->toDateString();
    $user = Auth::user();

    $pain = PainJour::where('paroisse_id', $user->paroisse_id)
        ->where('date_pain', $today)
        ->first();

    if (!$pain) {
        return response()->json(['status' => false, 'message' => 'Aucun pain du jour publié aujourd’hui.']);
    }
    return response()->json([
        'status' => true,
        'pain' => [
            'message' => $pain->message,
            'date' => $pain->date_pain,
            'est_auto' => $pain->est_auto,
        ],
    ]);
    
}

public function historiqueUtilisateur()
{
    $user = Auth::user();
    
    // Récupère tous les pains du jour de la paroisse de l'utilisateur, du plus récent au plus ancien
    $pains = PainJour::where('paroisse_id', $user->paroisse_id)
        ->orderBy('date_pain', 'desc')
        ->get(['date_pain as date', 'message']);  // on renomme date_pain en date pour correspondre à la réponse JSON attendue
    
    return response()->json([
        'status' => true,
        'data' => $pains,
    ]);
}

}