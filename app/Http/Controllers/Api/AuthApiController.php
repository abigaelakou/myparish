<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends Controller
{
    //
    /**
     * Connexion de l'utilisateur (paroissien)
     */
    public function login(Request $request)
    {
        // Validation des données de la requête
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Si validation échoue
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Tentative d'authentification
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => false,
                'message' => 'Email ou mot de passe invalide.'
            ], 401);
        }

        // Récupération de l'utilisateur authentifié
        $user = Auth::user();

        // Vérification si c'est bien un utilisateur paroissien
        if ((int) $user->id_type_utilisateur !== 6) {
            return response()->json([
                'status' => false,
                'message' => 'Accès réservé aux paroissiens.'
            ], 403);
        }
        
        // Génération d'un token pour l'authentification mobile
        $token = $user->createToken('token-paroissien')->plainTextToken;

        // Réponse avec les informations de l'utilisateur et le token
        return response()->json([
            'status' => true,
            'message' => 'Connexion réussie.',
            'token' => $token,
            'user' => $user->load('paroisse'), // chargement de la paroisse
        ]);
    }

    
    public function registerParoissien(Request $request)
{
    // Validation des données
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'contact' => 'required|string|max:15|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'paroisse_id' => 'required|exists:paroisses,id',

        // Données profil paroissien
        'sexe' => 'required|string|in:Masculin,Féminin',
        'situation_matrimoniale' => 'required|string',
        'date_naiss' => 'required|date_format:Y-m-d',
        'sacrement_recu' => 'nullable|array',
        'sacrement_recu.*' => 'string'
    ]);

    DB::beginTransaction();
    try {
        // Création de l'utilisateur
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'contact' => $validated['contact'],
            'password' => Hash::make($validated['password']),
            'id_type_utilisateur' => 6, // Paroissien
            'paroisse_id' => $validated['paroisse_id'],
        ]);

        // Création du profil paroissien
        $user->paroissien()->create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'contact' => $user->contact,
            'sexe' => $validated['sexe'],
            'situation_matrimoniale' => $validated['situation_matrimoniale'],
            'date_naiss' => $validated['date_naiss'],
            'sacrement_recu' => isset($validated['sacrement_recu'])
                ? implode(',', $validated['sacrement_recu'])
                : null,
            'paroisse_id' => $validated['paroisse_id'],
            'date_inscription' => now(),
        ]);

        // Génération d’un token de connexion
        $token = $user->createToken('token-paroissien')->plainTextToken;

        DB::commit();

         // ✅ Vérification si l'email est déjà utilisé dans cette paroisse
        $exists = User::where('email', $request->email)
            ->whereHas('paroissien', function ($query) use ($request) {
                $query->where('paroisse_id', $request->paroisse_id);
            })
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Un compte existe déjà avec cet email dans cette paroisse.'
            ], 409); // 409 = Conflit
        }

        return response()->json([
            'status' => true,
            'message' => 'Inscription réussie.',
            'token' => $token,
            'user' => $user->load('paroisse')
        ], 201);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
            'status' => false,
            'message' => 'Erreur lors de l\'inscription : ' . $e->getMessage()
        ], 500);
    }
}


    public function user(Request $request)
    {
        $user = $request->user()->load('paroisse');
        return response()->json($user);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Déconnexion réussie']);
    }

    // Changer le mot de passe

    public function changePassword(Request $request)
    {
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed', // 'confirmed' regarde le champ new_password_confirmation
    ]);

    $user = Auth::user();

    // Vérifie l'ancien mot de passe
    if (!Hash::check($request->current_password, $user->password)) {
        return response()->json([
            'message' => 'Le mot de passe actuel est incorrect.'
        ], 422);
    }

    // Met à jour le mot de passe
    $user->password = Hash::make($request->new_password);
    $user->save();

    return response()->json([
        'message' => 'Mot de passe modifié avec succès.'
    ]);
}


public function updateExpoToken(Request $request)
{
    $request->validate([
        'expo_token' => 'required|string',
    ]);

    $user = $request->user();
    $user->expo_token = $request->expo_token;
    $user->save();

    return response()->json(['message' => 'Token enregistré avec succès']);
}

    public function forgot_password(Request $request)
        {
        $request->validate(['email' => 'required|email']);
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json(['message' => 'Aucun utilisateur trouvé avec cet email.'], 404);
            }
            // Utilise le système standard de reset de Laravel
            Password::sendResetLink($request->only('email'));
            return response()->json(['message' => 'Lien envoyé si l\'email est valide.']);

        }

}