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
    public function create_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'contact' => 'required|string|max:15|unique:users',
            'id_type_utilisateur' => 'required|integer|exists:type_utilisateurs,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $utilisateur = new User();
        $utilisateur->name = $request->name;
        $utilisateur->email = $request->email;
        $utilisateur->contact = $request->contact;
        $utilisateur->password = Hash::make($request->password);
        $utilisateur->id_type_utilisateur = $request->id_type_utilisateur;
        // dd($utilisateur);
        $utilisateur->save();

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

        return redirect()->route('profile.edit')->with('success', 'Mot de passe mis à jour avec succès.');
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

        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

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
}
