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

        // Récupérer la demande
        $demande = DemandeMesse::find($request->id_demande);

        // Variables de paiement
        $montant = $request->montant;
        $contact = $request->contact;
        $moyenPaiement = $request->moyen_paiement;

        // Déterminer le service de paiement à utiliser
        $paymentService = null;

        switch ($moyenPaiement) {
            case 'moov':
                $paymentService = new MoovPaymentService();
                break;
            case 'orange':
                $paymentService = new OrangePaymentService();
                break;
            case 'mtn':
                $paymentService = new MtnPaymentService();
                break;
            case 'wave':
                $paymentService = new WavePaymentService();
                break;
            default:
                return redirect()->back()->with('error', 'Moyen de paiement non reconnu.');
        }

        // Appeler le service de paiement pour traiter la transaction
        $response = $paymentService->processPayment($montant, $contact);

        if ($response['status'] === 'success') {
            // Mise à jour du statut de la demande
            $demande->statut = 'payée';
            $demande->save();

            // Enregistrement du paiement dans la table paiements
            $paiement = new paiement();
            $paiement->id_demande = $demande->id;
            $paiement->montant = $montant;
            $paiement->contact = $contact;
            $paiement->moyen_paiement = $moyenPaiement;
            $paiement->save();

            // Enregistrement des détails de la transaction
            $transaction = new Transactions();
            $transaction->paiement_id = $paiement->id;
            $transaction->transaction_id = $response['transaction_id'];
            $transaction->date = now()->format('Y-m-d H:i:s');
            $transaction->save();

            // Enregistrer les détails de la transaction dans la session pour la confirmation
            session(['transaction_details' => [
                'transaction_id' => $response['transaction_id'],
                'amount' => $montant,
                'moyen_paiement' => $moyenPaiement,
                'date' => now()->format('Y-m-d H:i:s'),
            ]]);

            // dd(session('transaction_details'));
            // Redirection vers une page de confirmation avec un message de succès
            return redirect()->route('formConfirmation')->with('success', 'Paiement réussi, demande de messe enregistrée.');
        } else {
            // En cas d'échec du paiement
            return redirect()->back()->with('error', 'Le paiement a échoué. Veuillez réessayer.');
        }
    }

    public function confirmationPageDemande(Request $request)
    {
        $transactionDetails = session('transaction_details');
        // dd($transactionDetails);
        // Vérifier si les détails de la transaction existent dans la session
        if (!$transactionDetails) {
            return redirect()->back()->with('error', 'Aucune transaction trouvée.');
        }

        return view('Espaces.Messe.formConfirmation', compact('transactionDetails'));
    }
}