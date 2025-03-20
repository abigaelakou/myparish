<?php

namespace App\Http\Controllers;

use App\Models\Paroisse;
use App\Models\TypeUtilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
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

        // Récupérer l'utilisateur connecté
        $connectedUser = Auth::user();
        $paroisse_id = $connectedUser->paroisse_id; // Récupérer l'identifiant de la paroisse associée

        // Création de l'utilisateur
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'contact' => $validatedData['contact'],
            'password' => Hash::make($validatedData['password']),
            'id_type_utilisateur' => $validatedData['id_type_utilisateur'],
            'paroisse_id' => $paroisse_id, // Utiliser l'identifiant de la paroisse connectée
            'profile_image' => null,
        ]);

        // Enregistrement des informations supplémentaires
        $this->storeUserDetails($user, $request, $validatedData['id_type_utilisateur']);

        return redirect()->route('formAddUser')->with('success', 'Utilisateur créé avec succès.');
    }


    // Fonction pour gérer l'enregistrement des détails utilisateur
    private function storeUserDetails(User $user, Request $request, $userType)
    {
        if (in_array($userType, ['4', '6', '7', '9', '10'])) {
            $paroissienData = $request->validate([
                'sexe_p' => 'required|string',
                'situation_matrimoniale' => 'required|string',
                'date_naiss' => 'required|date_format:d-m-Y',
                'sacrement_recu.*' => 'required|string',
            ]);

            $date_naiss = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date_naiss)->format('Y-m-d');

            $user->paroissien()->create([
                'user_id' => $user->id,
                'name' => $user->name,
                'contact' => $user->contact,
                'email' => $user->email,
                'sexe' => $paroissienData['sexe_p'],
                'situation_matrimoniale' => $paroissienData['situation_matrimoniale'],
                'date_naiss' => $date_naiss,
                'sacrement_recu' => implode(',', $paroissienData['sacrement_recu']),
                'date_inscription' => now(),
                'paroisse_id' => $user->paroisse_id,
            ]);
        } elseif ($userType == '8') {
            $non_paroissienData = $request->validate(['sexe_np' => 'required|string']);
            $user->non_paroissien()->create([
                'user_id' => $user->id,
                'name' => $user->name,
                'contact' => $user->contact,
                'email' => $user->email,
                'sexe' => $non_paroissienData['sexe_np'],
                'paroisse_id' => $user->paroisse_id,
            ]);
        }
    }

    // Afficher les paroisses et les types utilisateurs
    public function showFormAddUser()
    {
        $type_utilisateurs = TypeUtilisateur::whereNotIn('id', [1])->get(); // Exclure le rôle Super Admin
        $paroisses = Paroisse::all(); // Récupérer toutes les paroisses
        return view('Espaces.Admin.formAddUser', compact('paroisses', 'type_utilisateurs'));
    }

    // Vérifier si l'email existe
    public function checkEmail(Request $request)
    {
        $exists = User::where('email', $request->email)->exists();
        return response()->json(['exists' => $exists]);
    }

    // Mise à jour du mot de passe
    public function update_password(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('changerMotPasse')->with('success', 'Mot de passe mis à jour avec succès.');
    }

    // Liste des utilisateurs
    public function list_users()
    {
        return User::with(['typeUtilisateur', 'paroisse'])
            ->get();
    }

    // Modification des utilisateurs
    public function update_user(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'id_user' => 'required|integer|exists:users,id',
            'modif_name' => 'required|string|max:255',
            'modif_email' => 'required|string|email|max:255|unique:users,email,' . $request->id_user,
            'modif_contact' => 'required|string|max:15',
            'modif_id_type_utilisateur' => 'required|integer|exists:type_utilisateurs,id',
            'modif_paroisse_id' => 'nullable|integer|exists:paroisses,id', // Nullable car non requis lorsqu'aucune paroisse n'est associé
        ]);

        // Récupération de l'utilisateur
        $user = User::findOrFail($validatedData['id_user']);

        // Vérification du type d'utilisateur (Super Admin n'a pas de paroisse)
        if ($validatedData['modif_id_type_utilisateur'] == 1) {
            // Mise à jour sans paroisse
            $user->update([
                'name' => $validatedData['modif_name'],
                'email' => $validatedData['modif_email'],
                'contact' => $validatedData['modif_contact'],
                'id_type_utilisateur' => $validatedData['modif_id_type_utilisateur'],
            ]);
        } else {
            // Mise à jour avec paroisse
            $user->update([
                'name' => $validatedData['modif_name'],
                'email' => $validatedData['modif_email'],
                'contact' => $validatedData['modif_contact'],
                'id_type_utilisateur' => $validatedData['modif_id_type_utilisateur'],
                'paroisse_id' => $validatedData['modif_paroisse_id'],
            ]);
        }

        // Retourner une réponse JSON
        return response()->json(['success' => 'Utilisateur mis à jour avec succès.']);
    }



    // Mise à jour du statut utilisateur
    public function update_status($user_id, $status_code)
    {
        try {
            User::whereId($user_id)
                ->where('paroisse_id', auth()->user()->paroisse_id)
                ->update(['status' => $status_code]);
            return response()->json(['success' => 'Statut mis à jour avec succès.']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Erreur lors de la mise à jour du statut.']);
        }
    }

    // Statistiques
    public function statistiques()
    {
        $nombre_utilisateur = User::count();

        return view('Espaces.Admin.statistiques', compact('nombre_utilisateur'));
    }

    public function index()
    {
        Log::info('Utilisateur connecté', ['utilisateur' => auth()->user()]);

        if (auth()->check() && auth()->user()->id_type_utilisateur == 1) {
            return view('Espaces/template');
        }
        return redirect('/unauthorized');
    }

    // Changer l'image de profil
    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();
        // Supprimer l'ancienne image si elle existe et n'est pas l'image par défaut
        if ($user->profile_image && $user->profile_image !== 'user.png') {
            Storage::delete('public/profile_images/' . $user->profile_image);
        }

        // Enregistrer la nouvelle image
        $file = $request->file('profile_image');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/profile_images', $filename);

        // Mettre à jour l'image dans la base de données
        $user->profile_image = basename($path);
        $user->save();

        return response()->json(['image' => asset('storage/profile_images/' . $user->profile_image)]);
    }
}
