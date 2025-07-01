<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PainDuJour;
use App\Models\Paroisse;
use App\Models\User;
use App\Models\ExpoToken;
use App\Models\PainJour;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class GenererPainAutomatique extends Command
{
    protected $signature = 'pain:generer-auto';
    protected $description = 'Génère automatiquement un pain du jour pour chaque paroisse si aucun n\'a été publié';

    public function handle()
    {
        $aujourdhui = Carbon::today();
        $paroisses = Paroisse::all();

        foreach ($paroisses as $paroisse) {
            $painExistant = PainJour::where('paroisse_id', $paroisse->id)
                ->where('date_pain', $aujourdhui)
                ->first();

            if ($painExistant) {
                $this->info("Pain déjà publié pour la paroisse : " . $paroisse->nom);
                continue;
            }

            // Exemple de contenu automatique
            $message = "Soyez bénis ! Que la paix de Dieu vous accompagne en ce jour. Gardez confiance en Lui.";

            $pain = PainJour::create([
                'titre' => 'Message du jour',
                'contenu' => $message,
                'date_pain' => $aujourdhui,
                'paroisse_id' => $paroisse->id,
                'id_user' => null,
                'est_auto' => true,
            ]);

            $this->info("Pain généré pour la paroisse : " . $paroisse->nom);

            // ➤ Envoi de notification push aux fidèles de la paroisse
            $tokens = ExpoToken::whereHas('user', function ($q) use ($paroisse) {
                $q->where('paroisse_id', $paroisse->id);
            })->pluck('token');

            foreach ($tokens as $token) {
                $this->envoyerNotificationExpo($token, 'Pain du jour', $message);
            }
        }

        return 0;
    }

    protected function envoyerNotificationExpo($expoToken, $title, $body)
    {
        if (!str_starts_with($expoToken, 'ExponentPushToken')) {
            Log::warning("Token Expo invalide : " . $expoToken);
            return;
        }

        $response = Http::post('https://exp.host/--/api/v2/push/send', [
            'to' => $expoToken,
            'title' => $title,
            'body' => $body,
        ]);

        if ($response->successful()) {
            Log::info("Notification envoyée à $expoToken");
        } else {
            Log::error("Erreur d'envoi Expo : " . $response->body());
        }
    }
}
