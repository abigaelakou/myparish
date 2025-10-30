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
    /**
     * Connexion de l'utilisateur (paroissien)
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => false,
                'message' => 'Email ou mot de passe invalide.'
            ], 401);
        }

        $user = Auth::user();

        if ((int) $user->id_type_utilisateur !== 6) {
            return response()->json([
                'status' => false,
                'message' => 'Accès réservé aux paroissiens.'
            ], 403);
        }

        $token = $user->createToken('token-paroissien')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Connexion réussie.',
            'token' => $token,
            'user' => $user->load('paroisse'),
        ]);
    }

    /**
     * Inscription d'un paroissien
     */
    public function registerParoissien(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'contact' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
            'paroisse_id' => 'required|exists:paroisses,id',

            'sexe' => 'required|string|in:Masculin,Féminin',
            'situation_matrimoniale' => 'required|string',
            'date_naiss' => 'required|date_format:Y-m-d',
            'sacrement_recu' => 'nullable|array',
            'sacrement_recu.*' => 'string'
        ]);

        // Vérification email unique dans la paroisse
        $emailExists = User::where('email', $validated['email'])
            ->whereHas('paroissien', function ($query) use ($validated) {
                $query->where('paroisse_id', $validated['paroisse_id']);
            })
            ->exists();

        if ($emailExists) {
            return response()->json([
                'status' => false,
                'message' => 'Un compte existe déjà avec cet email dans cette paroisse.'
            ], 409);
        }

        // Vérification contact unique dans la paroisse
        $contactExists = User::where('contact', $validated['contact'])
            ->whereHas('paroissien', function ($query) use ($validated) {
                $query->where('paroisse_id', $validated['paroisse_id']);
            })
            ->exists();

        if ($contactExists) {
            return response()->json([
                'status' => false,
                'message' => 'Un compte existe déjà avec ce contact dans cette paroisse.'
            ], 409);
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'contact' => $validated['contact'],
                'password' => Hash::make($validated['password']),
                'id_type_utilisateur' => 6,
                'paroisse_id' => $validated['paroisse_id'],
            ]);

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

            $token = $user->createToken('token-paroissien')->plainTextToken;

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Inscription réussie.',
                'token' => $token,
                'user' => $user->load('paroisse'),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de l\'inscription : ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupération de l'utilisateur connecté
     */
    public function user(Request $request)
    {
        $user = $request->user()->load('paroisse');
        return response()->json($user);
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Déconnexion réussie']);
    }

    /**
     * Changer mot de passe
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Le mot de passe actuel est incorrect.'
            ], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Mot de passe modifié avec succès.'
        ]);
    }

    /**
     * Mise à jour Expo Token
     */
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

    /**
     * Mot de passe oublié
     */
    public function forgot_password(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'Aucun utilisateur trouvé avec cet email.'], 404);
        }

        Password::sendResetLink($request->only('email'));

        return response()->json(['message' => 'Lien envoyé si l\'email est valide.']);
    }
}