<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pays;

class PaysApiController extends Controller
{
    /**
     * Liste de tous les pays
     */
    public function index()
    {
        try {
            $pays = Pays::orderBy('nom', 'asc')->get();
            
            return response()->json([
                'status' => true,
                'pays' => $pays
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de la récupération des pays',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupère un pays spécifique
     */
    public function show($id)
    {
        try {
            $pays = Pays::findOrFail($id);
            
            return response()->json([
                'status' => true,
                'pays' => $pays
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Pays non trouvé'
            ], 404);
        }
    }
}