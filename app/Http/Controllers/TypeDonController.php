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
        $type_don->save();

        return redirect()->route('formTypeDon')->with('success', 'Type don créé avec succès.');
    }

    // Modification des information 
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
        // Mise à jour de type_don
        $modif_type_don = TypeDon::find($request->id_type_don);
        $modif_type_don->lib_type_don = $request->modif_lib_type_don;
        $modif_type_don->save();
        return true;
    }

    // Liste
    public function list_type_don()
    {
        $liste_type_don = DB::table('type_dons')->get();
        return $liste_type_don;
    }
    // Suppression de type_don
    public function supp_type_don($id)
    {
        DB::table("type_dons")->where("id", $id)->delete();
        return true;
    }
}
