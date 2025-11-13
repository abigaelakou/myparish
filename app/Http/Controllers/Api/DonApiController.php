<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Don;
use App\Models\TypeDon;
use App\Models\Transaction;
use App\Models\Paiement;
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
            'mode_paiement' => 'required|string|in:moov,orange,mtn,wave,visa',
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

        // Utiliser une transaction DB pour garantir l'intégrité
        DB::beginTransaction();
        
        try {
            // Forcer description non-null
            $description = $request->description ?? '';
            
            // Générer un transaction_id unique si non fourni
            $transactionId = $request->transaction_id ?? uniqid('txn_');

            // 1. Création du don
            $don = Don::create([
                'description' => $description,
                'date_don' => Carbon::now()->toDateString(),
                'mode_paiement' => $request->mode_paiement,
                'transaction_id' => $transactionId,
                'payment_status' => 'en attente',
                'contact' => $contactPaiement,
                'montant' => $request->montant,
                'type_donateur' => $anonymous ? 'autre' : 'utilisateur',
                'donateur_id'   => $anonymous ? null : $user->id,
                'id_type_don' => $request->id_type_don,
                'paroisse_id' => $user->paroisse_id,
                'anonyme' => $anonymous,
            ]);

            // 2. Paiement lié au don
            $paiement = Paiement::create([
                'id_don' => $don->id,
                'moyen_paiement' => $request->mode_paiement,
                'montant' => $request->montant,
                'contact' => $contactPaiement,
                'paroisse_id' => $user->paroisse_id,
            ]);

            // 3. Transaction liée
            $transaction = Transaction::create([
                'source_id' => $don->id,
                'source_type' => 'don',
                'transaction_id' => $transactionId,
                'paroisse_id' => $user->paroisse_id,
                'montant' => $request->montant,
                'status' => 'en attente',
                'paiement_id' => $paiement->id,
                'date' => now(),
            ]);

            // Valider la transaction
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Don enregistré avec succès.',
                'don' => $don,
                'paiement' => $paiement,
                'transaction' => $transaction
            ], 201);

        } catch (\Exception $e) {
            // Annuler toutes les modifications en cas d'erreur
            DB::rollBack();
            
            // Logger l'erreur pour le débogage
            Log::error('Erreur lors de la création du don', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de l\'enregistrement du don: ' . $e->getMessage()
            ], 500);
        }
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

    // ✅ Simulation de validation de transaction
    public function simulerValidationTransaction($transactionId)
    {
        $transaction = Transaction::where('transaction_id', $transactionId)->firstOrFail();

        $transaction->update(['status' => 'success']);

        if ($transaction->source_type === 'don' && $transaction->don) {
            $transaction->don->update(['payment_status' => 'validé']);
        }

        return response()->json([
            'status' => true,
            'message' => 'Transaction simulée comme validée.',
            'transaction' => $transaction,
            'don' => $transaction->don,
        ]);
    }

    // ✅ Simulation d'échec de transaction
    public function simulerEchecTransaction($transactionId)
    {
        $transaction = Transaction::where('transaction_id', $transactionId)->firstOrFail();

        $transaction->update(['status' => 'failed']);

        if ($transaction->source_type === 'don' && $transaction->don) {
            $transaction->don->update(['payment_status' => 'échoué']);
        }

        return response()->json([
            'status' => true,
            'message' => 'Transaction simulée comme échouée.',
            'transaction' => $transaction,
            'don' => $transaction->don,
        ]);
    }
}