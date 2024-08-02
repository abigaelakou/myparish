<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class TypeUserController extends Controller
{
    //
    public function create()
    {

        $type_utilisateurs = DB::table('type_utilisateurs')->orderBy('lib_type_utilisateur')->get();
        // dd($type_utilisateurs);
        return view('Espaces.Admin.formAddUser', compact('type_utilisateurs'));
    }
}