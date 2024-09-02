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

    public function type_utilisateur_celebrant()
    {
        $type_de_messes = DB::table('type_messes')->orderBy('lib_type_messe')->get();

        // Récupère aussi les célébrants si nécessaire
        $celebrants = DB::table('users')
            ->join('type_utilisateurs', 'users.id_type_utilisateur', '=', 'type_utilisateurs.id')
            ->whereIn('type_utilisateurs.lib_type_utilisateur', ['PRETRE', 'CURE'])
            ->select('users.id', 'type_utilisateurs.lib_type_utilisateur', 'users.name')
            ->get();

        return view('Espaces.Messe.formMesse', compact('type_de_messes', 'celebrants'));
    }
}
