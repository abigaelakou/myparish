<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paroisse;

class ParoisseApiController extends Controller
{
    public function listeActives()
    {
        $paroisses = Paroisse::where('status', 1) // statut actif
            ->select('id', 'nom_paroisse')
            ->orderBy('nom_paroisse')
            ->get();

        return response()->json([
            'paroisses' => $paroisses
        ]);
    }
}
