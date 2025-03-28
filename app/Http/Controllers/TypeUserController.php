<?php

namespace App\Http\Controllers;

use App\Models\TypeMesse;
use App\Models\TypeUtilisateur;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PgSql\Lob;

class TypeUserController extends Controller
{
    //

    public function create()
    {
        Log::info('Type utilisateur:', [
            'user_id' => auth()->id(),
            'type_utilisateur' => auth()->user()->type_utilisateur
        ]);

        $type_utilisateurs = TypeUtilisateur::orderBy('lib_type_utilisateur')->get();
        return view('Espaces.Admin.formAddUser', compact('type_utilisateurs'));
    }

    public function type_utilisateur_celebrant()
    {
        $type_de_messes = TypeMesse::orderBy('lib_type_messe')->get();

        // Récupère les célébrants associés à la paroisse de l'utilisateur connecté
        $celebrants = User::whereHas('typeUtilisateur', function ($query) {
            $query->whereIn('lib_type_utilisateur', ['PRETRE', 'CURE']);
        })
            ->where('paroisse_id', auth()->user()->paroisse_id) // Filtrer par paroisse
            ->select('id', 'name')
            ->get();

        return view('Espaces.Messe.formMesse', compact('type_de_messes', 'celebrants'));
    }
}
