<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        if ($user->lib_type_utilisateur !== 'paroissien') {
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
            'user' => $user
        ]);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
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

}
