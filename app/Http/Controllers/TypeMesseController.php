<?php

namespace App\Http\Controllers;

use App\Models\TypeMesse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TypeMesseController extends Controller
{
    // Création d'un type de messe
    public function create_type_messe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lib_type_messe' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $type_messe = new TypeMesse();
        $type_messe->lib_type_messe = $request->lib_type_messe;
        $type_messe->paroisse_id = auth()->user()->paroisse_id; // Associer paroisse_id de l'utilisateur
        $type_messe->save();

        return redirect()->route('formTypeMesseIntention')->with('success', 'Type de messe créé avec succès.');
    }

    // Liste des types de messe pour la paroisse de l'utilisateur
    public function list_type_messe()
    {
        $liste_type_messe = DB::table('type_messes')
            ->join('paroisses', 'type_messes.paroisse_id', '=', 'paroisses.id')
            ->select('type_messes.*', 'paroisses.nom_paroisse')
            ->where('type_messes.paroisse_id', auth()->user()->paroisse_id) // Filtrer par paroisse de l'utilisateur
            ->get();

        return $liste_type_messe;
    }

    // Modification des informations d'un type de messe
    public function update_type_messe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_type_messe' => 'required|integer|exists:type_messes,id',
            'modif_lib_type_messe' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Vérifier que le type de messe appartient à la paroisse de l'utilisateur
        $modif_type_messe = TypeMesse::where('id', $request->id_type_messe)
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->first();

        if (!$modif_type_messe) {
            return redirect()->back()->with('error', 'Modification non autorisée.');
        }

        $modif_type_messe->lib_type_messe = $request->modif_lib_type_messe;
        $modif_type_messe->save();

        return redirect()->back()->with('success', 'Type de messe mis à jour avec succès.');
    }

    // Suppression d'un type de messe
    public function supp_type_messe($id)
    {
        $deleted = TypeMesse::where('id', $id)
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->delete();

        if ($deleted) {
            return response()->json(['success' => 'Type de messe supprimé avec succès.']);
        } else {
            return response()->json(['error' => 'Suppression échouée ou non autorisée.'], 403);
        }
    }
}