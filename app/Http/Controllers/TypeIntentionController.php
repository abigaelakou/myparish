<?php

namespace App\Http\Controllers;

use App\Models\TypeIntention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TypeIntentionController extends Controller
{
    //
    public function create_type_intention(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lib_type_intention' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $type_intention = new TypeIntention();
        $type_intention->lib_type_intention = $request->lib_type_intention;
        $type_intention->paroisse_id = auth()->user()->paroisse_id; // Récupérer paroisse_id depuis l'utilisateur connecté
        $type_intention->save();

        return redirect()->route('formTypeMesseIntention')->with('success', 'Type intention créé avec succès.');
    }

    // Modification des informations
    public function update_type_intention(Request $request)
    {
        Log::info($request->all());

        $validator = Validator::make($request->all(), [
            'id_type_intention' => 'required|integer|exists:type_intentions,id',
            'modif_lib_type_intention' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Vérifier que le type d'intention appartient à la paroisse de l'utilisateur
        $modif_type_intention = TypeIntention::where('id', $request->id_type_intention)
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->first();

        if (!$modif_type_intention) {
            return redirect()->back()->with('error', 'Modification non autorisée.');
        }

        $modif_type_intention->lib_type_intention = $request->modif_lib_type_intention;
        $modif_type_intention->save();

        return redirect()->route('listTypeIntention')->with('success', 'Type intention mis à jour avec succès.');
    }

    // Liste des types d'intentions
    public function list_type_intention()
    {
        $liste_type_intention = DB::table('type_intentions')
            ->join('paroisses', 'type_intentions.paroisse_id', '=', 'paroisses.id')
            ->select('type_intentions.*', 'paroisses.nom_paroisse')
            ->where('type_intentions.paroisse_id', auth()->user()->paroisse_id) // Filtrer par paroisse de l'utilisateur
            ->get();

        return $liste_type_intention;
    }

    // Suppression d'un type d'intention
    public function supp_type_intention($id)
    {
        $deleted = TypeIntention::where('id', $id)
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->delete();

        if ($deleted) {
            return response()->json(['success' => 'Type intention supprimé avec succès.']);
        } else {
            return response()->json(['error' => 'Suppression échouée ou non autorisée.'], 403);
        }
    }
}