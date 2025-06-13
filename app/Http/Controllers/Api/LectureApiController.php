<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LectureBiblique;
use Illuminate\Support\Facades\Auth;

class LectureApiController extends Controller
{
    /**
     * Récupérer la lecture biblique du jour pour l'utilisateur connecté
     */
    public function lectureDuJour()
    {
        $user = Auth::user();

        $lecture = LectureBiblique::where('paroisse_id', $user->paroisse_id)
            ->where('date_lecture', now()->toDateString())
            ->first();

        if (!$lecture) {
            return response()->json([
                'status' => false,
                'message' => 'Aucune lecture biblique trouvée pour aujourd’hui.'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Lecture du jour récupérée avec succès.',
            'lecture' => $lecture
        ]);
    }

    /**
     * Lister les lectures bibliques à venir (optionnel)
     */
    public function prochainesLectures()
    {
        $user = Auth::user();

        $lectures = LectureBiblique::where('paroisse_id', $user->paroisse_id)
            ->where('date_lecture', '>=', now()->toDateString())
            ->orderBy('date_lecture')
            ->take(7)
            ->get();

        return response()->json([
            'status' => true,
            'lectures' => $lectures
        ]);
    }
}
