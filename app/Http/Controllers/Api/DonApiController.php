<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Don;
use App\Models\TypeDon;
use Carbon\Carbon;

class DonApiController extends Controller
{
    public function mesDons()
    {
        $user = Auth::user();

        $dons = Don::where('paroisse_id', $user->paroisse_id)
            ->where('donateur_id', $user->id)
            ->orderBy('date_don', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Liste des dons récupérée avec succès.',
            'dons' => $dons
        ]);
    }

public function faireUnDon(Request $request)
{
    $request->validate([
        'description' => 'nullable|string',
        'mode_paiement' => 'required|string|in:moov,orange,mtn,wave,especes',
        'montant' => 'required|numeric|min:1',
        'contact' => 'nullable|string',
        'id_type_don' => 'required|exists:type_dons,id',
        'anonymous_donation' => 'nullable|boolean',
        'transaction_id' => 'nullable|string',
    ]);

    $user = Auth::user();
    $anonymous = $request->boolean('anonymous_donation', false);
    $modePaiement = strtolower($request->mode_paiement);

    // Vérifier le contact pour Mobile Money
    $mobileMoneyModes = ['moov', 'mtn', 'orange', 'wave'];
    $contactPaiement = $request->contact;

    if (in_array($modePaiement, $mobileMoneyModes) && empty($contactPaiement)) {
        return response()->json([
            'status' => false,
            'message' => 'Numéro de Mobile Money requis pour ce type de paiement.'
        ], 422);
    }

    // Forcer description non-null
    $description = $request->description ?? '';

    $don = Don::create([
        'description' => $description,
        'date_don' => Carbon::now()->toDateString(),
        'mode_paiement' => $request->mode_paiement,
        'transaction_id' => $request->transaction_id ?? null,
        'payment_status' => 'en attente',
        'contact' => $contactPaiement,
        'montant' => $request->montant,
        'type_donateur' => $anonymous ? null : $user->id,
        'donateur_id' => $anonymous ? null : $user->id,
        'id_type_don' => $request->id_type_don,
        'paroisse_id' => $user->paroisse_id,
        'anonyme' => $anonymous,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Don enregistré avec succès.',
        'don' => $don
    ]);
}


    public function getTypesDonParoisse()
    {
        $user = Auth::user();
        $types = TypeDon::where('paroisse_id', $user->paroisse_id)->get();

        return response()->json([
            'status' => true,
            'types' => $types
        ]);
    }
}