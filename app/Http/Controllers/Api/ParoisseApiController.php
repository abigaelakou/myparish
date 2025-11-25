<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paroisse;
use Illuminate\Http\Request;

class ParoisseApiController extends Controller
{
    /**
     * Liste des paroisses actives (status = 1) avec relations
     */
    public function listeActives()
    {
        try {
            $paroisses = Paroisse::where('status', 1)
                ->with(['diocese.pays'])
                ->select('id', 'nom_paroisse', 'adresse', 'contact', 'email', 'status', 'diocese_id')
                ->orderBy('nom_paroisse', 'asc')
                ->get();

            return response()->json($paroisses);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de la récupération des paroisses',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupère une paroisse spécifique par ID
     */
    public function show($id)
    {
        try {
            $paroisse = Paroisse::findOrFail($id);
            
            return response()->json([
                'status' => true,
                'paroisse' => $paroisse
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Paroisse non trouvée'
            ], 404);
        }
    }

    /**
     * Liste de toutes les paroisses (pour admin)
     */
    public function index()
    {
        try {
            $paroisses = Paroisse::orderBy('nom_paroisse', 'asc')->get();
            
            return response()->json([
                'status' => true,
                'paroisses' => $paroisses
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de la récupération des paroisses',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}