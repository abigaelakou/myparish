<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Diocese;

class DioceseApiController extends Controller
{
  public function index()
    {
        try {
            $dioceses = Diocese::with('pays')
                ->orderBy('nom', 'asc')
                ->get();
            
            return response()->json([
                'status' => true,
                'dioceses' => $dioceses
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de la récupération des diocèses',
                'error' => $e->getMessage()
            ], 500);
        }
    }

   /**
     * Récupère les diocèses d'un pays spécifique
     */
    public function getByPays($paysId)
    {
        try {
            $dioceses = Diocese::where('pays_id', $paysId)
                ->with('pays')
                ->orderBy('nom', 'asc')
                ->get();
            
            return response()->json([
                'status' => true,
                'dioceses' => $dioceses
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de la récupération des diocèses',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    /**
     * Récupère un diocèse spécifique
     */
    public function show($id)
    {
        try {
            $diocese = Diocese::with('pays')->findOrFail($id);
            
            return response()->json([
                'status' => true,
                'diocese' => $diocese
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Diocèse non trouvé'
            ], 404);
        }
    }
}