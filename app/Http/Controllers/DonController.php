<?php

// namespace App\Http\Controllers;

// use App\Models\Don;
// use App\Models\Transactions;
// use App\Models\User;
// use Illuminate\Http\Request;
// use App\PaymentServices\MoovPaymentService;
// use App\PaymentServices\OrangePaymentService;
// use App\PaymentServices\MtnPaymentService;
// use App\PaymentServices\WavePaymentService;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Log;

// class DonController extends Controller
// {
//     public function showDonationForm()
//     {
//         return view('Espaces.Don.formDon');
//     }

//     public function processDonation(Request $request)
//     {
//         $request->validate([
//             'montant' => 'required|numeric',
//             'contact' => 'required|numeric',
//             'mode_paiement' => 'required|string',
//             'description' => 'nullable|string',
//             'id_type_don' => 'required|exists:type_dons,id',
//             'paroisse_id' => 'required|exists:paroisses,id',

//         ]);

//         $montant = $request->montant;
//         $contact = $request->contact;
//         $modePaiement = $request->mode_paiement;

//         // Sélection du service de paiement
//         $paymentService = null;
//         switch ($modePaiement) {
//             case 'moov':
//                 $paymentService = new MoovPaymentService();
//                 break;
//             case 'orange':
//                 $paymentService = new OrangePaymentService();
//                 break;
//             case 'mtn':
//                 $paymentService = new MtnPaymentService();
//                 break;
//             case 'wave':
//                 $paymentService = new WavePaymentService();
//                 break;
//             default:
//                 return redirect()->back()->withErrors(['mode_paiement' => 'Mode de paiement non reconnu.']);
//         }

//         // Traitement du paiement
//         $response = $paymentService->processPayment($montant, $contact);
//         $paymentStatus = $response['status'] === 'success' ? 'Payé' : 'Echec';

//         // Si l'utilisateur coche "anonyme", on assigne l'ID de l'utilisateur "Anonyme"
//         $anonymousUserId = User::where('name', 'Anonyme')->first()->id;
//         $donateurId = $request->has('anonymous_donation') && $request->anonymous_donation == 1
//             ? $anonymousUserId
//             : auth()->user()->id; // Sinon, c'est l'utilisateur connecté

//         $don = new Don();
//         $don->description = $request->description;
//         $don->montant = $montant;
//         $don->date_don = now();
//         $don->mode_paiement = $modePaiement;
//         $don->transaction_id = $response['transaction_id'];
//         $don->payment_status = $paymentStatus;
//         $don->donateur_id = $donateurId;
//         $don->type_donateur = $request->has('anonymous_donation') && $request->anonymous_donation == 1 ? 'anonyme' : 'paroissien';
//         $don->id_type_don = $request->id_type_don;
//         $don->contact = $contact;
//         $don->paroisse_id = $request->paroisse_id;
//         $don->save();

//         session(['transaction_details' => [
//             'transaction_id' => $response['transaction_id'] ?? null,
//             'amount' => $montant,
//             'moyen_paiement' => $modePaiement,
//             'date' => now(),
//         ]]);


//         // Redirection en fonction du statut du paiement
//         if ($paymentStatus === 'Payé') {
//             return redirect()->route('confirmation')->with('success', 'Don effectué avec succès.');
//         } else {
//             return redirect()->route('failed')->with('error', 'Le paiement a échoué. Veuillez réessayer.');
//         }
//     } 
// }

namespace App\Http\Controllers;

use App\Models\Don;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\PaymentServices\MoovPaymentService;
use App\PaymentServices\OrangePaymentService;
use App\PaymentServices\MtnPaymentService;
use App\PaymentServices\WavePaymentService;

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
            'contact' => 'nullable|string', // nullable pour anonymes
            'mode_paiement' => 'required|string',
            'description' => 'nullable|string',
            'id_type_don' => 'required|exists:type_dons,id',
            'paroisse_id' => 'required|exists:paroisses,id',
            'anonymous_donation' => 'nullable|boolean',
        ]);

        $montant = $request->montant;
        $contact = $request->contact;
        $modePaiement = $request->mode_paiement;
        $paroisseId = $request->paroisse_id;
        $anonymous = $request->boolean('anonymous_donation', false);

        // Choix du service de paiement (selon mode et, idéalement, paroisse)
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
                return redirect()->back()->withErrors(['mode_paiement' => 'Mode de paiement non reconnu.']);
        }

        // Appel au paiement via API externe (le service doit gérer le paiement et retourner un status)
        $response = $paymentService->processPayment($montant, $contact);
        $paymentStatus = ($response['status'] === 'success') ? 'validé' : 'échoué';

        // Gestion donateur
        if ($anonymous) {
            $donateurId = null;
            $typeDonateur = 'anonyme';
            $contact = null; // on masque le contact si anonyme
        } else {
            $donateurId = Auth::id();
            $typeDonateur = 'utilisateur';
            // si contact absent, on peut forcer le contact utilisateur
            if (!$contact) {
                $contact = Auth::user()->contact ?? null;
            }
        }

        // Création du don
        $don = Don::create([
            'description' => $request->description,
            'montant' => $montant,
            'date_don' => now()->toDateString(),
            'mode_paiement' => $modePaiement,
            'transaction_id' => $response['transaction_id'] ?? null,
            'payment_status' => $paymentStatus,
            'donateur_id' => $donateurId,
            'type_donateur' => $typeDonateur,
            'contact' => $contact,
            'id_type_don' => $request->id_type_don,
            'paroisse_id' => $paroisseId,
            'anonyme' => $anonymous,
        ]);

        // Enregistrement dans transactions
        Transaction::create([
            'source_id' => $don->id,
            'source_type' => 'don',
            'transaction_id' => $response['transaction_id'] ?? null,
            'paroisse_id' => $paroisseId,
            'montant' => $montant,
            'status' => $paymentStatus,
            'date' => now(),
        ]);

        // Stockage session pour confirmation
        session(['transaction_details' => [
            'transaction_id' => $response['transaction_id'] ?? null,
            'amount' => $montant,
            'moyen_paiement' => $modePaiement,
            'date' => now(),
        ]]);

        if ($paymentStatus === 'validé') {
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
        $paroisseId = auth()->user()->paroisse_id;

        $typesDons = DB::table('type_dons')
            ->where('paroisse_id', $paroisseId) // Filtre par paroisse
            ->orderBy('lib_type_don')
            ->get();

        $userDons = DB::table('users')
            ->where('paroisse_id', $paroisseId) // Filtre par paroisse
            ->orderBy('name')
            ->get();

        return view('Espaces.Don.formDon', compact('typesDons', 'userDons'));
    }


    public function liste_don()
    {
        // Récupérer tous dons
        $dons = Don::with('typeDon', 'user')
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->get();
        return response()->json($dons);
    }


    // Liste des dons de l'utilisateur connecté
    public function listUserDons()
    {
        $userId = Auth::id();
        $dons_util = Don::where('donateur_id', $userId)
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->with('typeDon')
            ->get();
        return response()->json($dons_util);
    }
}
