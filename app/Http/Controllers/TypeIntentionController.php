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
        $type_intention->save();

        return redirect()->route('formTypeMesseIntention')->with('success', 'Type intention créé avec succès.');
    }

    // Modification des information 
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
        // Mise à jour de messe
        $modif_type_intention = TypeIntention::find($request->id_type_intention);
        $modif_type_intention->lib_type_intention = $request->modif_lib_type_intention;
        $modif_type_intention->save();
        return true;
    }

    // Liste
    public function list_type_intention()
    {
        $liste_type_intention = DB::table('type_intentions')->get();
        return $liste_type_intention;
    }
    // Suppression de messe
    public function supp_type_messe($id)
    {
        DB::table("type_intentions")->where("id", $id)->delete();
        return true;
    }
}