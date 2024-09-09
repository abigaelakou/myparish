<?php

namespace App\Http\Controllers;

use App\Models\Don;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use App\PaymentServices\MoovPaymentService;
use App\PaymentServices\OrangePaymentService;
use App\PaymentServices\MtnPaymentService;
use App\PaymentServices\WavePaymentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DonController extends Controller
{
    public function showDonationForm()
    {
        return view('Espaces.Don.formDon');
    }

    public function processDonation(Request $request)
    {
        $request->validate([
            'montant' => 'required|numeric',
            'contact' => 'required|numeric',
            'mode_paiement' => 'required|string',
            'description' => 'nullable|string',
            'id_type_don' => 'required|exists:type_dons,id',
        ]);

        $montant = $request->montant;
        $contact = $request->contact;
        $modePaiement = $request->mode_paiement;

        // Sélection du service de paiement
        $paymentService = null;
        switch ($modePaiement) {
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
                return redirect()->back()->with('error', 'Mode de paiement non reconnu.');
        }

        // Traitement du paiement
        $response = $paymentService->processPayment($montant, $contact);
        $paymentStatus = $response['status'] === 'success' ? 'Payé' : 'Echec';

        // Si l'utilisateur coche "anonyme", on assigne l'ID de l'utilisateur "Anonyme"
        $anonymousUserId = User::where('name', 'Anonyme')->first()->id;
        $donateurId = $request->has('anonymous_donation') && $request->anonymous_donation == 1
            ? $anonymousUserId
            : auth()->user()->id; // Sinon, c'est l'utilisateur connecté

        $don = new Don();
        $don->description = $request->description;
        $don->montant = $montant;
        $don->date_don = now();
        $don->mode_paiement = $modePaiement;
        $don->transaction_id = $response['transaction_id'];
        $don->payment_status = $paymentStatus;
        $don->donateur_id = $donateurId;
        $don->type_donateur = $request->has('anonymous_donation') && $request->anonymous_donation == 1 ? 'anonyme' : 'paroissien';
        $don->id_type_don = $request->id_type_don;
        $don->contact = $contact;
        $don->save();

        session(['transaction_details' => [
            'transaction_id' => $response['transaction_id'],
            'amount' => $montant,
            'moyen_paiement' => $modePaiement,
            'date' => now(),
        ]]);

        // Redirection en fonction du statut du paiement
        if ($paymentStatus === 'Payé') {
            return redirect()->route('confirmation')->with('success', 'Don effectué avec succès.');
        } else {
            return redirect()->route('failed')->with('error', 'Le paiement a échoué. Veuillez réessayer.');
        }
    }

    public function confirmationPage()
    {
        $transactionDetails = session('transaction_details');

        // Vérifier si les détails de la transaction existent dans la session
        if (!$transactionDetails) {
            return redirect()->back()->with('error', 'Aucune transaction trouvée.');
        }
        return view('Espaces.Don.confirmation', compact('transactionDetails'));
    }

    public function failedPaymentPage()
    {
        return view('Espaces.Don.failed');
    }

    public function show_type_don()
    {

        $typesDons = DB::table('type_dons')->orderBy('lib_type_don')->get();
        $userDons = DB::table('users')->orderBy('name')->get();
        return view('Espaces.Don.formDon', compact('typesDons', 'userDons'));
    }


    public function liste_don()
    {
        // Récupérer tous dons
        $dons = Don::with('typeDon', 'user')->get();
        // dd($dons);
        return response()->json($dons);
    }


    // Liste des dons de l'utilisateur connecté
    public function listUserDons()
    {
        $userId = Auth::id(); // Récupérer l'ID de l'utilisateur connecté
        $dons_util = Don::where('donateur_id', $userId)->with('typeDon')->get(); // Récupérer les dons de l'utilisateur connecté
        // dd($dons_util);
        return response()->json($dons_util);
    }
}
