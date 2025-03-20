<?php

namespace App\Http\Controllers;

use App\Models\TypeDon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TypeDonController extends Controller
{
    //
    public function create_type_don(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lib_type_don' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $type_don = new TypeDon();
        $type_don->lib_type_don = $request->lib_type_don;
        $type_don->paroisse_id = auth()->user()->paroisse_id; // Récupérer paroisse_id depuis l'utilisateur connecté
        $type_don->save();

        return redirect()->route('formTypeDon')->with('success', 'Type don créé avec succès.');
    }

    // Modification des informations
    public function update_type_don(Request $request)
    {
        Log::info($request->all());

        $validator = Validator::make($request->all(), [
            'id_type_don' => 'required|integer|exists:type_dons,id',
            'modif_lib_type_don' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Vérifier que le type de don appartient à la paroisse de l'utilisateur
        $modif_type_don = TypeDon::where('id', $request->id_type_don)
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->first();

        if (!$modif_type_don) {
            return redirect()->back()->with('error', 'Modification non autorisée.');
        }

        $modif_type_don->lib_type_don = $request->modif_lib_type_don;
        $modif_type_don->save();

        return redirect()->route('listTypeDon')->with('success', 'Type don mis à jour avec succès.');
    }

    // Liste des types de dons
    public function list_type_don()
    {
        $liste_type_don = DB::table('type_dons')
            ->join('paroisses', 'type_dons.paroisse_id', '=', 'paroisses.id')
            ->select('type_dons.*', 'paroisses.nom_paroisse')
            ->where('type_dons.paroisse_id', auth()->user()->paroisse_id) // Filtrer par paroisse de l'utilisateur
            ->get();
        return $liste_type_don;
    }

    // Suppression d'un type de don
    public function supp_type_don($id)
    {
        $deleted = TypeDon::where('id', $id)
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->delete();

        if ($deleted) {
            return response()->json(['success' => 'Type don supprimé avec succès.']);
        } else {
            return response()->json(['error' => 'Suppression échouée ou non autorisée.'], 403);
        }
    }
}