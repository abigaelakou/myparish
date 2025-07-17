<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class NotificationController extends Controller
{
    public function sendNotification(Request $request)
    {
        // Validation
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $user = User::find($request->user_id);

        if (!$user->expo_token) {
            return response()->json(['message' => 'Aucun token Expo trouvé pour cet utilisateur'], 404);
        }

        // Envoi de la notification via l’API d’Expo
        $response = Http::post('https://exp.host/--/api/v2/push/send', [
            'to' => $user->expo_token,
            'sound' => 'default',
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return response()->json([
            'message' => 'Notification envoyée',
            'expo_response' => $response->json(),
        ]);
    }
}
