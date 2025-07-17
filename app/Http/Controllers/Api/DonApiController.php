<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Don;
use App\Models\Transaction;
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
            'mode_paiement' => 'required|string',
            'montant' => 'required|numeric',
            'contact' => 'nullable|string',
            'id_type_don' => 'required|exists:type_dons,id',
            'anonymous_donation' => 'nullable|boolean',
        ]);

        $user = Auth::user();
        $anonymous = $request->boolean('anonymous_donation', false);

        if ($anonymous) {
            $donateurId = null;
            $typeDonateur = 'anonyme';
            $contact = null;
        } else {
            $donateurId = $user->id;
            $typeDonateur = 'utilisateur';
            $contact = $request->contact ?? $user->contact;
        }

        $don = Don::create([
            'description' => $request->description,
            'date_don' => Carbon::now()->toDateString(),
            'mode_paiement' => $request->mode_paiement,
            // 'transaction_id' => null, 
            'transaction_id' => $request->transaction_id ?? null,
            'payment_status' => 'en attente',
            'contact' => $contact,
            'montant' => $request->montant,
            'type_donateur' => $typeDonateur,
            'donateur_id' => $donateurId,
            'id_type_don' => $request->id_type_don,
            'paroisse_id' => $user->paroisse_id,
            'anonyme' => $anonymous,
        ]);

        // Tu peux aussi enregistrer la transaction après paiement réel

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
