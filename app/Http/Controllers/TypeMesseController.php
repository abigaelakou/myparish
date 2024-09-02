<?php

namespace App\Http\Controllers;

use App\Models\TypeMesse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TypeMesseController extends Controller
{
    //
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
        $type_messe->save();
        return redirect()->route('formTypeMesseIntention')->with('success', 'Type messe créé avec succès.');
    }
    //liste 
    public function list_type_messe()
    {
        $liste_type_messe = DB::table('type_messes')->get();
        return $liste_type_messe;
    }

    // Modification des information 
    public function update_type_messe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_type_messe' => 'required|integer|exists:type_messes,id',
            'modif_lib_type_messe' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Mise à jour de messe
        $modif_type_messe = TypeMesse::find($request->id_type_messe);
        $modif_type_messe->lib_type_messe = $request->modif_lib_type_messe;
        $modif_type_messe->save();
        return true;
    }

    // Suppression de messe
    public function supp_type_messe($id)
    {
        DB::table("type_messes")->where("id", $id)->delete();
        return true;
    }
}