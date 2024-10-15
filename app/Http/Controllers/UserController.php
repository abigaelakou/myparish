<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Ajout utilisateur
    // public function create_user(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //         'contact' => 'required|string|max:15|unique:users',
    //         'id_type_utilisateur' => 'required|integer|exists:type_utilisateurs,id',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $utilisateur = new User();
    //     $utilisateur->name = $request->name;
    //     $utilisateur->email = $request->email;
    //     $utilisateur->contact = $request->contact;
    //     $utilisateur->password = Hash::make($request->password);
    //     $utilisateur->id_type_utilisateur = $request->id_type_utilisateur;
    //     // dd($utilisateur);
    //     $utilisateur->save();

    //     return redirect()->route('formAddUser')->with('success', 'Utilisateur créé avec succès.');
    // }
    public function create_user(Request $request)
    {
        // Validation des données de base
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'contact' => 'required|string|max:15|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'id_type_utilisateur' => 'required|exists:type_utilisateurs,id',
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'contact' => $validatedData['contact'],
            'password' => Hash::make($validatedData['password']),
            'id_type_utilisateur' => $validatedData['id_type_utilisateur']
        ]);

        // Si le type d'utilisateur est PAROISSIEN, enregistrer les informations dans la table paroissiens
        if ($validatedData['id_type_utilisateur'] == '3' || $validatedData['id_type_utilisateur'] == '5' || $validatedData['id_type_utilisateur'] == '6' || $validatedData['id_type_utilisateur'] == '8' || $validatedData['id_type_utilisateur'] == '9') {
            $paroissienData = $request->validate([
                'sexe_p' => 'required|string',
                'situation_matrimoniale' => 'required|string',
                'date_naiss' => 'required|date',
                'sacrement_recu.*' => 'required|string',
            ]);

            $user->paroissien()->create([
                'user_id' => $user->id,
                'name' => $user->name, // Récupération du nom de la table users
                'contact' => $user->contact, // Récupération du contact de la table users
                'email' => $user->email, // Récupération de l'email de la table users
                'sexe' => $paroissienData['sexe_p'],
                'situation_matrimoniale' => $paroissienData['situation_matrimoniale'],
                'date_naiss' => $paroissienData['date_naiss'],
                'sacrement_recu' => implode(',', $paroissienData['sacrement_recu']),
                'date_inscription' => now(),
            ]);
            // Sinon si le type d'utilisateur est NON PAROISSIEN, enregistrer les informations dans la table paroissiens
        } elseif ($validatedData['id_type_utilisateur'] == '7') {
            $non_paroissienData = $request->validate([
                'sexe_np' => 'required|string',
            ]);

            $user->non_paroissien()->create([
                'user_id' => $user->id,
                'name' => $user->name, // Récupération du nom de la table users
                'contact' => $user->contact, // Récupération du contact de la table users
                'email' => $user->email, // Récupération de l'email de la table users
                'sexe' => $non_paroissienData['sexe_np']
            ]);
        }
        // Redirection
        return redirect()->route('formAddUser')->with('success', 'Utilisateur créé avec succès.');
    }

    // verifier si l'email existe
    public function checkEmail(Request $request)
    {
        $exists = User::where('email', $request->email)->exists();
        return response()->json(['exists' => $exists]);
    }

    // Mise à jour du mot de passe
    public function update_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::table("users")
            ->where("id", Auth::id())
            ->update([
                "password" => Hash::make($request->password)
            ]);

        return redirect()->route('changerMotPasse')->with('success', 'Mot de passe mis à jour avec succès.');
    }

    // Liste des utilisateurs

    public function list_users()
    {
        $liste_utilisateur = DB::table('users')
            ->join('type_utilisateurs', 'users.id_type_utilisateur', '=', 'type_utilisateurs.id')
            ->select('users.*', 'type_utilisateurs.lib_type_utilisateur')
            ->get();
        return $liste_utilisateur;
        // return view('Espaces.Admin.listeUser', compact('liste_utilisateur'));
    }
    public function edit_user($id)
    {
        $utilisateur = User::findOrFail($id);
        $types_utilisateurs = DB::table('type_utilisateurs')->get();
        return response()->json([
            'utilisateur' => $utilisateur,
            'types_utilisateurs' => $types_utilisateurs
        ]);
    }

    // Modification des utilisateurs
    public function update_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|integer|exists:users,id',
            'modif_name' => 'required|string|max:255',
            'modif_email' => 'required|string|email|max:255|unique:users,email,' . $request->id_user,
            'modif_contact' => 'required|string|max:15|',
            'modif_id_type_utilisateur' => 'required|integer|exists:type_utilisateurs,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $modif_users = User::find($request->id_user);
        $modif_users->name = $request->modif_name;
        $modif_users->email = $request->modif_email;
        $modif_users->contact = $request->modif_contact;
        $modif_users->id_type_utilisateur = $request->modif_id_type_utilisateur;
        $modif_users->save();
        return true;
    }

    // Mise à jour du staut utilisateur

    public function update_status($user_id, $status_code)
    {
        try {
            $mise_a_jour_statut = User::whereId($user_id)->update([
                'status' => $status_code
            ]);
            if ($mise_a_jour_statut) {
                return response()->json(['success' => 'Statut mis à jour avec succès.']);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Erreur lors de la mise à jour du statut.']);
        }
    }

    // Statistiques
    public function statistiques()
    {
        $nombre_utilisateur = DB::table("users")->count();

        $donnee = [
            "nombre_utilisateur" => $nombre_utilisateur,
        ];

        return view('Espaces.Admin.statistiques', compact('donnee'));
    }
    public function index()
    {
        // Log l'utilisateur connecté
        Log::info('Utilisateur connecté', ['utilisateur' => auth()->user()]);

        if (auth()->check() && auth()->user()->id_type_utilisateur == 1) {
            return view('Espaces/template');
        }



        return redirect('/unauthorized');
    }
}
