<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Don;
use Carbon\Carbon;

class DonApiController extends Controller
{
    /**
     * Récupérer les dons effectués par le paroissien connecté
     */
    public function mesDons()
    {
        $user = Auth::user();

        $dons = Don::where('paroisse_id', $user->paroisse_id)
            ->where('type_donateur', 'utilisateur')
            ->where('donateur_id', $user->id)
            ->orderBy('date_don', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Liste des dons récupérée avec succès.',
            'dons' => $dons
        ]);
    }

    /**
     * Faire un don
     */
    public function faireUnDon(Request $request)
    {
        $request->validate([
            'description' => 'nullable|string',
            'mode_paiement' => 'required|string',
            'montant' => 'required|numeric',
            'contact' => 'required|string',
            'id_type_don' => 'required|exists:type_dons,id',
        ]);

        $user = Auth::user();

        $don = Don::create([
            'description' => $request->description,
            'date_don' => Carbon::now()->toDateString(),
            'mode_paiement' => $request->mode_paiement,
            'transaction_id' => null, // à compléter après paiement effectif
            'payment_status' => 'en attente', // ou 'validé' si paiement immédiat
            'contact' => $request->contact,
            'montant' => $request->montant,
            'type_donateur' => 'utilisateur',
            'donateur_id' => $user->id,
            'id_type_don' => $request->id_type_don,
            'paroisse_id' => $user->paroisse_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Don enregistré avec succès.',
            'don' => $don
        ]);
    }
}
