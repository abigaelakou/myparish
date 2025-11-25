<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PainJour;
use App\Models\Annonce;
use App\Models\Evenement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * Envoyer une notification push Expo à tous les paroissiens d'une paroisse
     */
    public function sendPushNotification(Request $request)
    {
        $request->validate([
            'paroisse_id' => 'required|exists:paroisses,id',
            'title' => 'required|string',
            'body' => 'required|string',
            'data' => 'nullable|array',
        ]);

        // Récupérer tous les utilisateurs de la paroisse avec un expo_token
        $users = User::where('paroisse_id', $request->paroisse_id)
            ->whereNotNull('expo_token')
            ->where('expo_token', '!=', '')
            ->get();

        if ($users->isEmpty()) {
            return response()->json([
                'message' => 'Aucun utilisateur avec token Expo trouvé',
                'sent' => 0
            ]);
        }

        $messages = [];
        foreach ($users as $user) {
            $messages[] = [
                'to' => $user->expo_token,
                'sound' => 'default',
                'title' => $request->title,
                'body' => $request->body,
                'data' => $request->data ?? [],
                'badge' => 1, // Ajouter un badge
                'priority' => 'high',
            ];
        }

        try {
            $response = Http::post('https://exp.host/--/api/v2/push/send', $messages);

            if ($response->successful()) {
                return response()->json([
                    'message' => 'Notifications envoyées avec succès',
                    'sent' => count($messages),
                    'response' => $response->json()
                ]);
            }

            return response()->json([
                'message' => 'Erreur lors de l\'envoi',
                'error' => $response->body()
            ], 500);
        } catch (\Exception $e) {
            Log::error('Erreur notification push: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur serveur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Envoyer une notification lors de la création d'un Pain du Jour
     */
    public function notifyNewPainDuJour($painJourId)
    {
        $pain = PainJour::with('paroisse')->find($painJourId);
        
        if (!$pain) return;

        $this->sendPushNotification(new Request([
            'paroisse_id' => $pain->paroisse_id,
            'title' => '✝️ Nouveau Pain du Jour',
            'body' => $pain->titre,
            'data' => [
                'type' => 'pain_du_jour',
                'id' => $pain->id,
                'screen' => 'Home'
            ]
        ]));
    }

    /**
     * Envoyer une notification lors de la création d'une Annonce
     */
    public function notifyNewAnnonce($annonceId)
    {
        $annonce = Annonce::find($annonceId);
        
        if (!$annonce) return;

        $this->sendPushNotification(new Request([
            'paroisse_id' => $annonce->paroisse_id,
            'title' => '📢 Nouvelle Annonce',
            'body' => $annonce->titre,
            'data' => [
                'type' => 'annonce',
                'id' => $annonce->id,
                'screen' => 'Home'
            ]
        ]));
    }

    /**
     * Envoyer une notification lors de la création d'un Événement
     */
    public function notifyNewEvenement($evenementId)
    {
        $evenement = Evenement::find($evenementId);
        
        if (!$evenement) return;

        $this->sendPushNotification(new Request([
            'paroisse_id' => $evenement->paroisse_id,
            'title' => '🎉 Nouvel Événement',
            'body' => $evenement->lib_evenement,
            'data' => [
                'type' => 'evenement',
                'id' => $evenement->id,
                'screen' => 'Home'
            ]
        ]));
    }

    /**
     * Récupérer le nombre de nouveaux contenus pour l'utilisateur
     */
    public function getUnreadCount(Request $request)
    {
        $user = $request->user();
        
        // Récupérer le dernier ID consulté par l'utilisateur (stocker dans la table users ou nouvelle table)
        $lastPainId = $user->last_pain_id ?? 0;
        $lastAnnonceId = $user->last_annonce_id ?? 0;
        $lastEvenementId = $user->last_evenement_id ?? 0;

        $newPains = PainJour::where('paroisse_id', $user->paroisse_id)
            ->where('id', '>', $lastPainId)
            ->count();

        $newAnnonces = Annonce::where('paroisse_id', $user->paroisse_id)
            ->where('id', '>', $lastAnnonceId)
            ->count();

        $newEvenements = Evenement::where('paroisse_id', $user->paroisse_id)
            ->where('id', '>', $lastEvenementId)
            ->count();

        return response()->json([
            'unread_count' => $newPains + $newAnnonces + $newEvenements,
            'details' => [
                'pains' => $newPains,
                'annonces' => $newAnnonces,
                'evenements' => $newEvenements,
            ]
        ]);
    }

    /**
     * Marquer le contenu comme lu
     */
    public function markAsRead(Request $request)
    {
        $user = $request->user();
        
        $request->validate([
            'pain_id' => 'nullable|integer',
            'annonce_id' => 'nullable|integer',
            'evenement_id' => 'nullable|integer',
        ]);

        if ($request->has('pain_id')) {
            $user->last_pain_id = $request->pain_id;
        }
        if ($request->has('annonce_id')) {
            $user->last_annonce_id = $request->annonce_id;
        }
        if ($request->has('evenement_id')) {
            $user->last_evenement_id = $request->evenement_id;
        }

        $user->save();

        return response()->json(['message' => 'Marqué comme lu']);
    }
}