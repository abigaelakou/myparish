<?php

namespace App\Http\Controllers;

use App\Models\DemandeMesse;
use App\Models\paiement;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\PaymentServices\MoovPaymentService;
use App\PaymentServices\OrangePaymentService;
use App\PaymentServices\MTNPaymentService;
use App\PaymentServices\WavePaymentService;
use Illuminate\Support\Facades\Log;

class PaiementController extends Controller
{
    public function showPaiementForm($id_demande)
    {
        // Récupérer la demande de messe par ID
        $demande = DemandeMesse::findOrFail($id_demande);
        // Passer la demande à la vue du formulaire de paiement
        return view('Espaces.Messe.formPaiement', compact('demande'));
    }

    public function processPaiement(Request $request)
    {
        $request->validate([
            'id_demande' => 'required|exists:demande_messes,id',
            'montant' => 'required|numeric',
            'contact' => 'required|numeric',
            'moyen_paiement' => 'required|string',
        ]);

        $demande = DemandeMesse::find($request->id_demande);

        // Vérifier que la demande n'est pas déjà payée
        if ($demande->statut === 'payée') {
            return redirect()->back()->with('error', 'Cette demande a déjà été réglée.');
        }

        $montant = $request->montant;
        $contact = $request->contact;
        $moyenPaiement = $request->moyen_paiement;
        $paroisse_id = auth()->user()->paroisse_id; // Sécuriser le champ paroisse_id

        // Sélection du service de paiement
        $paymentService = match ($moyenPaiement) {
            'moov' => new MoovPaymentService(),
            'orange' => new OrangePaymentService(),
            'mtn' => new MtnPaymentService(),
            'wave' => new WavePaymentService(),
            default => null,
        };

        if (!$paymentService) {
            return redirect()->route('showPaiementForm', ['id_demande' => $request->id_demande])
                ->with('error', 'Moyen de paiement non reconnu.');
        }

        try {
            $response = $paymentService->processPayment($montant, $contact);

            if ($response['status'] === 'success') {
                // Mise à jour du statut de la demande
                $demande->statut = 'payée';
                $demande->save();

                $paiement = Paiement::create([
                    'id_demande' => $demande->id,
                    'montant' => $montant,
                    'contact' => $contact,
                    'moyen_paiement' => $moyenPaiement,
                    'paroisse_id' => $paroisse_id,
                ]);

                Transactions::create([
                    'paiement_id' => $paiement->id,
                    'transaction_id' => $response['transaction_id'],
                    'date' => now(),
                    'paroisse_id' => $paroisse_id,
                ]);

                session(['transaction_details' => [
                    'transaction_id' => $response['transaction_id'],
                    'amount' => $montant,
                    'moyen_paiement' => $moyenPaiement,
                    'date' => now()->format('Y-m-d H:i:s'),
                ]]);

                return redirect()->route('formConfirmation')->with('success', 'Paiement réussi, demande de messe enregistrée.');
            } else {
                return redirect()->back()->with('error', 'Le paiement a échoué. Veuillez réessayer.');
            }
        } catch (\Exception $e) {
            Log::error("Erreur de paiement: {$e->getMessage()}");
            return redirect()->back()->with('error', 'Une erreur est survenue lors du traitement du paiement.');
        }
    }

    public function confirmationPageDemande(Request $request)
    {
        $transactionDetails = session('transaction_details');

        if (!$transactionDetails) {
            return redirect()->route('demandeMesse')->with('error', 'Aucune transaction trouvée.');
        }

        return view('Espaces.Messe.confirmationPageDemande', compact('transactionDetails'));
    }
}