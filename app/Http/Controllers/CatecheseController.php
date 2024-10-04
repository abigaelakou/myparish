<?php

namespace App\Http\Controllers;

use App\Models\Catechumene;
use App\Models\ClasseCatechese;
use App\Models\DecisionCatechese;
use App\Models\Inscription;
use App\Models\PaiementCatechese;
use App\Models\PresenceCatechese;
use App\Models\RecuPaiement;
use App\Models\Affectation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\PaymentServices\MoovPaymentService;
use App\PaymentServices\OrangePaymentService;
use App\PaymentServices\MtnPaymentService;
use App\PaymentServices\WavePaymentService;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;

class CatecheseController extends Controller
{
    public function store_catechumene(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'contact' => 'nullable|numeric',
            'email' => 'nullable|email',
            'nom_prenom_pere' => 'required|string',
            'contact_pere' => 'nullable|numeric',
            'nom_prenom_mere' => 'required|string',
            'contact_mere' => 'nullable|numeric',
            'nom_prenom_parain' => 'nullable|string',
            'contact_parain' => 'nullable|numeric',
            'sacrement_recu' => 'required|array', // Validation pour un tableau
            'sacrement_recu.*' => 'string',
        ]);

        $sacrements = $request->sacrement_recu; // Récupérer les sacrements sélectionnés

        // Enregistrer les données d
        $catechumene = new Catechumene();
        $catechumene->name = $request->name;
        $catechumene->contact = $request->contact ?? null; // Utiliser null si non fourni
        $catechumene->email = $request->email ?? null; // Utiliser null si non fourni
        $catechumene->nom_prenom_pere = $request->nom_prenom_pere;
        $catechumene->contact_pere = $request->contact_pere ?? null; // Utiliser null si non fourni
        $catechumene->nom_prenom_mere = $request->nom_prenom_mere;
        $catechumene->contact_mere = $request->contact_mere ?? null; // Utiliser null si non fourni
        $catechumene->nom_prenom_parain = $request->nom_prenom_parain ?? null; // Utiliser null si non fourni
        $catechumene->contact_parain = $request->contact_parain ?? null; // Utiliser null si non fourni
        $catechumene->sacrement_recu = json_encode($sacrements); // Convertir le tableau en JSON pour le stockage
        $catechumene->save();
        return redirect()->route('formCatechumene')->with('success', 'Catechumene ajouté avec succès.');
    }

    public function liste_catechumene()
    {
        // Récupérer tous dons
        $liste_cate = DB::table('catechumenes')->get();
        return $liste_cate;
    }

    // Modification des infos catechumenes 
    public function update_catechumene(Request $request)
    {
        // Enregistrer les informations de la requête pour débogage
        Log::info($request->all());

        // Validation des données de la requête
        $validator = Validator::make($request->all(), [
            'id_catechumene' => 'required|integer|exists:catechumenes,id',
            'modif_name' => 'required|string',
            'modif_contact' => 'nullable|numeric',
            'modif_email' => 'nullable|email',
            'modif_nom_prenom_pere' => 'required|string',
            'modif_contact_pere' => 'nullable|numeric',
            'modif_nom_prenom_mere' => 'required|string',
            'modif_contact_mere' => 'nullable|numeric',
            'modif_nom_prenom_parain' => 'nullable|string',
            'modif_contact_parain' => 'nullable|numeric',
            'modif_sacrement_recu' => 'required|array', // Validation pour un tableau
            'modif_sacrement_recu.*' => 'string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Récupération des données à mettre à jour
        $modif_sacrements = $request->input('modif_sacrement_recu') ?: [];
        $modif_info_cate = Catechumene::find($request->input('id_catechumene'));

        if ($modif_info_cate) {
            $modif_info_cate->name = $request->input('modif_name');
            $modif_info_cate->contact = $request->input('modif_contact') ?: null;
            $modif_info_cate->email = $request->input('modif_email') ?: null;
            $modif_info_cate->nom_prenom_pere = $request->input('modif_nom_prenom_pere');
            $modif_info_cate->contact_pere = $request->input('modif_contact_pere') ?: null;
            $modif_info_cate->nom_prenom_mere = $request->input('modif_nom_prenom_mere');
            $modif_info_cate->contact_mere = $request->input('modif_contact_mere') ?: null;
            $modif_info_cate->nom_prenom_parain = $request->input('modif_nom_prenom_parain') ?: null;
            $modif_info_cate->contact_parain = $request->input('modif_contact_parain') ?: null;
            $modif_info_cate->sacrement_recu = json_encode($modif_sacrements);
            // Log::info($request->input('modif_sacrement_recu'));
            $modif_info_cate->save();
            return true;
        } else {
            // Redirection avec erreur si le catéchumène n'est pas trouvé
            return redirect()->back()->with('error', 'Catéchumène non trouvé.');
        }
    }


    public function supp_catechumene($id)
    {
        DB::table("catechumenes")->where("id", $id)->delete();
        return true;
    }

    //*************************GESTION DE CLASSE ET AFFECTIONS DANS LES CLASSES************************ */
    public function store_classe_catechese(Request $request)
    {
        $request->validate([
            'lib_classe_cate' => 'required|string',
            'id_niveau' => 'required|integer|exists:niveau_catechetiques,id',
            'id_session' => 'required|integer|exists:session_catecheses,id'
        ]);
        // Enregistrer les données d
        $classe_catechese = new ClasseCatechese();
        $classe_catechese->lib_classe_cate = $request->lib_classe_cate;
        $classe_catechese->id_niveau = $request->id_niveau;
        $classe_catechese->id_session = $request->id_session;
        $classe_catechese->id_user = Auth::id(); // Celui qui a crée la classe
        $classe_catechese->save();
        return redirect()->route('formClasse')->with('success', 'Classe crée avec succès.');
    }

    public function listeClasseCatechese()
    {
        // $list_classe_cate = ClasseCatechese::select('id', 'lib_classe_cate', 'id_niveau', 'id_session')->get();
        // dd($list_classe_cate);
        $classe_catechese = DB::table('classe_catecheses')
            ->join('niveau_catechetiques', 'classe_catecheses.id_niveau', '=', 'niveau_catechetiques.id')
            ->join('session_catecheses', 'classe_catecheses.id_session', '=', 'session_catecheses.id')
            ->select(
                'classe_catecheses.id',
                'classe_catecheses.id_niveau',
                'classe_catecheses.id_session',
                'classe_catecheses.lib_classe_cate',
                'niveau_catechetiques.lib_niveau as niveau',
                'session_catecheses.lib_session_catechese as session',
            )
            ->orderBy('classe_catecheses.lib_classe_cate', 'desc')
            ->get();
        // dd($classe_catechese);
        return $classe_catechese;
    }
    // Modification des information 
    public function update_classe(Request $request)
    {
        Log::info($request->all());

        $data = $request->validate([
            'id_classe' => 'required|integer|exists:classe_catecheses,id',
            'modif_lib_classe_cate' => 'required|string',
            'modif_id_session' => 'required|integer|exists:session_catecheses,id',
            'modif_id_niveau' => 'required|integer|exists:niveau_catechetiques,id',
        ]);
        $modif_classe = ClasseCatechese::find($request->id_classe);
        $modif_classe->lib_classe_cate = $request->modif_lib_classe_cate;
        $modif_classe->id_session = $request->modif_id_session;
        $modif_classe->id_niveau = $request->modif_id_niveau;
        // dd($request->all());
        $modif_classe->save();
        return true;
    }

    public function supp_classe_catechese($id)
    {
        DB::table("classe_catecheses")->where("id", $id)->delete();
        return true;
    }

    public function show_niv_session()
    {
        $list_niveaux = DB::table('niveau_catechetiques')->orderBy('lib_niveau')->get();
        $list_sessions = DB::table('session_catecheses')->orderBy('lib_session_catechese')->get();
        $list_classe_cate = ClasseCatechese::select('id', 'lib_classe_cate', 'id_niveau', 'id_session')->get();

        return view('Espaces.Catechese.formClasse', compact('list_niveaux', 'list_sessions', 'list_classe_cate'));
    }


    public function listeCatechumenesParClasse(Request $request)
    {
        $niveauId = $request->query('niveau');
        $sessionId = $request->query('session');

        // Récupérer les catéchumènes affectés à la classe sélectionnée
        $catechumenes = DB::table('catechumenes')
            ->join('inscriptions', 'catechumenes.id', '=', 'inscriptions.id_catechumene')
            ->join('classe_catecheses', function ($join) use ($niveauId, $sessionId) {
                $join->on('inscriptions.id_niveau', '=', 'classe_catecheses.id_niveau')
                    ->on('inscriptions.id_session', '=', 'classe_catecheses.id_session')
                    ->where('classe_catecheses.id_niveau', '=', $niveauId)
                    ->where('classe_catecheses.id_session', '=', $sessionId);
            })
            ->select('catechumenes.*') // Vous pouvez ajouter plus de colonnes si nécessaire
            ->get();

        // Retourner les catéchumènes au format JSON
        return response()->json($catechumenes);
    }

    // ************************GESTION PAIEMENT INSCRIPTION ET DECISIION FINALE***************

    public function info_catechese()
    {
        $currentYear = now()->year; // Année en cours
        $startYear = (now()->month >= 9) ? $currentYear : $currentYear - 1; // Si on est après août, l'année commence
        $endYear = $startYear + 1;

        $anneeCatechetique = "{$startYear}-{$endYear}";

        // dd($anneeCatechetique);
        $catecheses = DB::table('catechumenes')->orderBy('name')->get();
        $niveau_catecheses = DB::table('niveau_catechetiques')->orderBy('lib_niveau')->get();
        $session_catecheses = DB::table('session_catecheses')->orderBy('lib_session_catechese')->get();
        return view('Espaces.Catechese.formInscriptionKT', compact('catecheses', 'niveau_catecheses', 'session_catecheses', 'anneeCatechetique'));
    }

    public function showAttentePaiement($id_inscription)
    {
        return view('Espaces.Catechese.inscriptionAttente', compact('id_inscription'));
    }


    public function store_inscription(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'annee_catechetique' => 'required|string',
            'date_inscription' => 'required|date',
            'id_catechumene' => 'required|exists:catechumenes,id',
            'id_niveau' => 'required|exists:niveau_catechetiques,id',
            'id_session' => 'required|exists:session_catecheses,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Créer une nouvelle inscription
        $inscription = Inscription::create([
            'annee_catechetique' => $request->annee_catechetique,
            'date_inscription' => $request->date_inscription,
            'id_catechumene' => $request->id_catechumene,
            'id_user' => Auth::id(),
            'id_niveau' => $request->id_niveau,
            'id_session' => $request->id_session,
        ]);

        // Créer un paiement avec statut "En attente"
        PaiementCatechese::create([
            'id_inscription' => $inscription->id,
            'montant' => 0, // Montant initial
            'contact' => null, // Contact sera ajouté plus tard
            'mode_paiement' => null, // Mode de paiement sera choisi lors du paiement
            'payment_status' => 'En attente',
        ]);

        // Rediriger vers la page de confirmation
        return redirect()->route('inscriptionAttente', ['id_inscription' => $inscription->id])
            ->with('success', 'Inscription effectuée. Veuillez compléter le paiement.');
    }

    public function completePaymentForm(Request $request)
    {
        // Log::info('completePaymentForm called', $request->all());
        $inscriptionId = $request->input('id_inscription');
        $paiement = PaiementCatechese::where('id_inscription', $inscriptionId)
            ->where('payment_status', 'En attente')
            ->first();

        if (!$paiement) {
            return response()->json(['error' => 'Aucun paiement en attente trouvé pour cette inscription.'], 404);
        }

        if ($request->ajax()) {
            Log::info('AJAX request received');

            // Vérification du token CSRF
            if ($request->session()->token() != $request->input('_token')) {
                return response()->json(['error' => 'Invalid CSRF token'], 403);
            }

            return response()->json([
                'status' => 'success',
                'view' => view('Espaces.Catechese.espaceKT', compact('paiement'))->render()
            ]);
        }

        return view('Espaces.Catechese.paiementCompleter', compact('paiement'));
    }

    public function getForm($id_inscription)
    {
        // Récupérer les données nécessaires pour le paiement
        $paiement = PaiementCatechese::where('id_inscription', $id_inscription)
            ->where('payment_status', 'En attente')
            ->first();

        if (!$paiement) {
            return response()->json(['message' => 'Paiement non trouvé.'], 404);
        }

        // Retourner les données de paiement en JSON
        return response()->json($paiement);
    }


    public function validation_paiementCatechese(Request $request)
    {
        // Validation du formulaire
        $request->validate([
            'id_inscription' => 'required|exists:inscriptions,id',
            'montant' => 'required|numeric',
            'contact' => 'required|numeric',
            'mode_paiement' => 'required|string',
        ]);

        // Récupérer le paiement en attente
        $paiement = PaiementCatechese::where('id_inscription', $request->id_inscription)
            ->where('payment_status', 'En attente')
            ->first();

        if (!$paiement) {
            return redirect()->back()->with('error', 'Aucun paiement en attente trouvé.');
        }

        // Traitement du paiement
        $paymentService = $this->getPaymentService($request->mode_paiement);
        if (!$paymentService) {
            return redirect()->back()->with('error', 'Mode de paiement non reconnu.');
        }

        // Appeler le service de paiement
        $response = $paymentService->processPayment($request->montant, $request->contact);
        // dd($response);
        if (!$response || !isset($response['status'])) {
            return redirect()->back()->with('error', 'Erreur lors de la communication avec le service de paiement.');
        }
        // Mise à jour du paiement en fonction de la réponse
        $paiement->update([
            'montant' => $request->montant,
            'contact' => $request->contact,
            'mode_paiement' => $request->mode_paiement,
            'transaction_id' => $response['transaction_id'],
            'payment_status' => $response['status'] === 'success' ? 'Payé' : 'Échec',
            'date_paiement' => now(),
        ]);
        // dd($paiement->payment_status);
        if ($paiement->payment_status === 'Payé') {
            $inscription = Inscription::find($request->id_inscription);

            // Vérifier que l'inscription existe et récupérer le nom du catéchumène
            if ($inscription) {
                $catéchumène = Catechumene::find($inscription->id_catechumene);
                $nomPrenom = $catéchumène ? $catéchumène->name : 'Nom et Prénom non fournis';
            } else {
                $nomPrenom = 'Nom et Prénom non fournis';
            }

            // Enregistrer le reçu dans la base de données
            RecuPaiement::create([
                'id_paiement' => $paiement->id,
                'nom_prenom' => $nomPrenom,
                'montant' => $request->montant,
                'contact' => $request->contact,
                'date_paiement' => $paiement->date_paiement,
            ]);
            $recu = RecuPaiement::where('id_paiement', $paiement->id)->first();
            // dd($recu);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'recu' => $recu,
                    'message' => 'Paiement effectué avec succès. Un reçu a été généré.'
                ]);
            }
            return view('Espaces.Catechese.recu_paiement', compact('recu'))
                ->with('success', 'Paiement effectué avec succès. Un reçu a été généré.');
        }
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Le paiement a échoué.'
            ]);
        }
        return redirect()->route('failedInscription')->with('error', 'Le paiement a échoué.');
    }

    protected function getPaymentService($modePaiement)
    {
        switch ($modePaiement) {
            case 'moov':
                return new MoovPaymentService();
            case 'orange':
                return new OrangePaymentService();
            case 'mtn':
                return new MtnPaymentService();
            case 'wave':
                return new WavePaymentService();
            default:
                return null;
        }
    }

    public function failedKTPaymentPage()
    {
        return view('Espaces.Catechese.failedInscription');
    }
    // Téléchargé le reçu

    public function downloadRecu($id_paiement)
    {
        $recu = RecuPaiement::where('id_paiement', $id_paiement)->firstOrFail();
        //dd($recu);
        $pdf = FacadePdf::loadView('Espaces.Catechese.recu_paiement', ['recu' => $recu]);
        return $pdf->download('recu_paiement_' . $id_paiement . '.pdf');
    }
    //liste des catecumènes 
    public function listeInscritsAttente()
    {
        $inscriptions = Inscription::with(['paiements', 'catechumene', 'niveauCatechetique', 'sessionCatechese'])
            ->whereHas('paiements', function ($query) { //permet de filtrer les inscriptions en attente
                $query->where('payment_status', 'En attente');
            })
            ->get();
        // dd($inscriptions);
        return response()->json($inscriptions);
    }

    // liste des catechumènes inscris et ayant payé

    public function listeInscritsPayer()
    {
        $currentYear = now()->year; // Année en cours
        $startYear = (now()->month >= 9) ? $currentYear : $currentYear - 1; // Si on est après août, l'année commence
        $endYear = $startYear + 1;

        $anneeEnCours = "{$startYear}-{$endYear}";

        $catechumenes_inscris = DB::table('paiements_catechese')
            ->join('inscriptions', 'paiements_catechese.id_inscription', '=', 'inscriptions.id')
            ->join('catechumenes', 'inscriptions.id_catechumene', '=', 'catechumenes.id')
            ->join('niveau_catechetiques', 'inscriptions.id_niveau', '=', 'niveau_catechetiques.id')
            ->join('session_catecheses', 'inscriptions.id_session', '=', 'session_catecheses.id')
            ->where('inscriptions.annee_catechetique', '=', $anneeEnCours)
            ->where('paiements_catechese.payment_status', '=', 'Payé')
            ->select(
                'catechumenes.name as nom_prenom',
                'niveau_catechetiques.lib_niveau as niveau',
                'session_catecheses.lib_session_catechese as session',
                'paiements_catechese.date_paiement'
            )
            ->orderBy('paiements_catechese.date_paiement', 'desc')
            ->get();
        // dd($catechumenes_inscris);
        return $catechumenes_inscris;
    }


    public function ajouterPresence(Request $request)
    {
        $request->validate([
            'id_catechumene' => 'required|exists:catechumenes,id',
            'type_presence' => 'required|in:Catéchèse,Messe,CEB',
            'date_presence' => 'required|date',
        ]);

        $presence = new PresenceCatechese();
        $presence->id_catechumene = $request->id_catechumene;
        $presence->type_presence = $request->type_presence;
        $presence->date_presence = $request->date_presence;
        $presence->save();

        return redirect()->back()->with('success', 'Présence ajoutée avec succès');
    }


    public function info_catechese_deux()
    {
        $currentYear = now()->year; // Année en cours
        $startYear = (now()->month >= 9) ? $currentYear : $currentYear - 1; // Si on est après août, l'année commence
        $endYear = $startYear + 1;

        $anneeCatechetique_new = "{$startYear}-{$endYear}";

        // dd($anneeCatechetique);
        $catecheses_new = DB::table('catechumenes')->orderBy('name')->get();
        return view('Espaces.Catechese.formDecisionCatechumene', compact('catecheses_new', 'anneeCatechetique_new'));
    }


    public function enregistrerDecision(Request $request)
    {
        $request->validate([
            'id_catechumene' => 'required|exists:catechumenes,id',
            'annee_catechetique' => 'required|string',
            'moy_final' => 'required|string',
            'total_presence_catechese' => 'required|integer',
            'total_presence_messes' => 'required|integer',
            'total_presence_ceb' => 'required|integer',
            'decision_finale' => 'required|in:Admis,Recalé,Abandon,Clôturé',
        ]);

        $decision = new DecisionCatechese();
        $decision->id_catechumene = $request->id_catechumene;
        $decision->annee_catechetique = $request->annee_catechetique;
        $decision->moy_final = $request->moy_final;
        $decision->total_presence_catechese = $request->total_presence_catechese;
        $decision->total_presence_messes = $request->total_presence_messes;
        $decision->total_presence_ceb = $request->total_presence_ceb;
        $decision->decision_finale = $request->decision_finale;
        $decision->save();

        return redirect()->back()->with('success', 'Décision enregistrée avec succès');
    }

    //liste des decisions
    public function getListeCatechumenesAvecDecisions()
    {
        $currentYear = now()->year; // Année en cours
        $startYear = (now()->month >= 9) ? $currentYear : $currentYear - 1; // Si on est après août, l'année commence
        $endYear = $startYear + 1;

        $anneeEnCours = "{$startYear}-{$endYear}";

        // Récupérer les catéchumènes inscrits avec leur niveau, session et décision de fin d'année
        $catechumenes = DB::table('inscriptions')
            ->join('decisions_catechese', 'inscriptions.id_catechumene', '=', 'decisions_catechese.id_catechumene')
            ->join('catechumenes', 'inscriptions.id_catechumene', '=', 'catechumenes.id') // Pour récupérer le nom du catéchumène
            ->join('niveau_catechetiques', 'inscriptions.id_niveau', '=', 'niveau_catechetiques.id') // Pour récupérer le niveau
            ->join('session_catecheses', 'inscriptions.id_session', '=', 'session_catecheses.id') // Pour récupérer la session
            ->where('inscriptions.annee_catechetique', '=', $anneeEnCours) // Filtrer par année en cours
            // ->groupBy('inscriptions.id_catechumene')
            ->select(
                'catechumenes.name as nom_prenom', // Nom du catéchumène
                'niveau_catechetiques.lib_niveau as niveau', // Niveau
                'session_catecheses.lib_session_catechese as session', // Session
                'decisions_catechese.moy_final',
                'decisions_catechese.total_presence_catechese',
                'decisions_catechese.total_presence_messes',
                'decisions_catechese.total_presence_ceb',
                'decisions_catechese.decision_finale'
            )
            ->distinct()
            ->get();
        // dd($catechumenes);
        return response()->json($catechumenes);
    }


    public function update_decision(Request $request)
    {
        // Enregistrer les informations de la requête pour débogage
        Log::info($request->all());

        // Validation des données de la requête
        $validator = Validator::make($request->all(), [
            'id_decisions_catechese' => 'required|integer|exists:decisions_catechese,id',
            'modif_moy_final' => 'required|string',
            'modif_total_presence_catechese' => 'required|numeric',
            'modif_total_presence_messes' => 'required|numeric',
            'modif_total_presence_ceb' => 'required|numeric',
            'modif_id_catechumene' => 'required|exists:catechumenes,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $modif_decision = DecisionCatechese::find($request->id_decisions_catechese);
        $modif_decision->modif_moy_final = $request->modif_moy_final;
        $modif_decision->total_presence_catechese = $request->modif_total_presence_catechese;
        $modif_decision->total_presence_messes = $request->modif_total_presence_messes;
        $modif_decision->total_presence_ceb = $request->modif_total_presence_ceb;
        $modif_decision->id_catechumene = $request->modif_id_catechumene;
        // dd($request->all());
        $modif_decision->save();
        return true;
    }


    public function getliste_catechumene_fini()
    {
        // $anneeEnCours = '2024-2025'; 
        $catechumenes_fini = DB::table('decisions_catechese')
            ->join('inscriptions', 'decisions_catechese.id_catechumene', '=', 'inscriptions.id_catechumene')
            ->join('catechumenes', 'inscriptions.id_catechumene', '=', 'catechumenes.id')
            ->join('niveau_catechetiques', 'inscriptions.id_niveau', '=', 'niveau_catechetiques.id')
            ->join('session_catecheses', 'inscriptions.id_session', '=', 'session_catecheses.id')
            ->whereIn('decisions_catechese.decision_finale', ['Cloturé', 'Abandon'])
            // ->where('inscriptions.annee_catechetique', '=', $annee_catechetique)
            ->select(
                'catechumenes.name as nom_prenom',
                'niveau_catechetiques.lib_niveau as niveau',
                'session_catecheses.lib_session_catechese as session',
                'decisions_catechese.decision_finale',
                'decisions_catechese.annee_catechetique',
                // 'inscriptions.annee_catechetique'
            )
            ->orderBy('inscriptions.date_inscription', 'desc') // Optionnel, pour trier par date d'inscription
            ->get();
        return response()->json($catechumenes_fini);
    }
    // ************************************ GESTION DES AFFECTATIONS **************************************

    public function showForm()
    {
        $currentYear = now()->year; // Année en cours
        $startYear = (now()->month >= 9) ? $currentYear : $currentYear - 1; // Si on est après août, l'année commence
        $endYear = $startYear + 1;

        $anneeEnCours = "{$startYear}-{$endYear}";

        // Récupérer les catéchumènes inscrits pour l'année en cours avec un paiement effectué
        $catechumenes = DB::table('catechumenes')
            ->join('inscriptions', 'catechumenes.id', '=', 'inscriptions.id_catechumene')
            ->join('paiements_catechese', 'inscriptions.id', '=', 'paiements_catechese.id_inscription')
            ->where('inscriptions.annee_catechetique', '=', $anneeEnCours)
            ->where('paiements_catechese.payment_status', '=', 'Payé')
            ->select('catechumenes.id', 'catechumenes.name', 'inscriptions.id as inscription_id')
            ->get();

        // Récupérer toutes les classes disponibles
        $classes = ClasseCatechese::with('niveau', 'session')->get();

        // Retourner la vue avec les catéchumènes filtrés et les classes
        return view('Espaces.Catechese.affectation_catechumene', compact('catechumenes', 'classes'));
    }


    public function affecterCatechumene(Request $request)
    {
        // Validation des données soumises
        $data = $request->validate([
            'id_catechumene' => 'required|exists:catechumenes,id',
            'id_classe' => 'required|exists:classe_catecheses,id',
        ]);

        // Créer une nouvelle affectation
        $affectation = new Affectation();
        $affectation->id_catechumene = $data['id_catechumene'];
        $affectation->id_classe = $data['id_classe'];
        $affectation->date_affectation = now(); // Optionnel pour suivre la date d'affectation

        // Sauvegarder l'affectation
        $affectation->save();

        // Redirection avec un message de succès
        return redirect()->back()->with('success', 'Catéchumène affecté à la classe avec succès !');
    }

    // ******************************** STATISTIQUES ************************************
    public function statsParDecision() //permet de savoir combien de catéchumènes ont été "Cloturé", combien ont abandonné
    {
        $statsParDecision = DB::table('decisions_catechese')
            ->select('decision_finale', DB::raw('count(*) as total'))
            ->groupBy('decision_finale')
            ->get();
        return $statsParDecision;
    }

    public function statsParNiveau() //permet de voir la répartition des catéchumènes par niveau catéchétique
    {
        $statsParNiveau = DB::table('inscriptions')
            ->join('niveau_catechetiques', 'inscriptions.id_niveau', '=', 'niveau_catechetiques.id')
            ->select('niveau_catechetiques.lib_niveau', DB::raw('count(*) as total'))
            ->groupBy('niveau_catechetiques.lib_niveau')
            ->get();
        return $statsParNiveau;
    }

    public function statsParSession() //permet de voir la répartition des catéchumènes par session.
    {
        $statsParSession = DB::table('inscriptions')
            ->join('session_catecheses', 'inscriptions.id_session', '=', 'session_catecheses.id')
            ->select('session_catecheses.lib_session_catechese', DB::raw('count(*) as total'))
            ->groupBy('session_catecheses.lib_session_catechese')
            ->get();

        return $statsParSession;
    }

    public function statsParAnnee() //permet de voir combien de catéchumènes étaient inscrits chaque année.
    {
        $statsParAnnee = DB::table('inscriptions')
            ->select('annee_catechetique', DB::raw('count(*) as total'))
            ->groupBy('annee_catechetique')
            ->get();

        return $statsParAnnee;
    }

    public function statsAbandonClotureParNiveau() //permet de savoir combien de catéchumènes ont abandonné ou terminé par niveau spécifique.
    {
        $statsAbandonClotureParNiveau = DB::table('decisions_catechese')
            ->join('inscriptions', 'decisions_catechese.id_catechumene', '=', 'inscriptions.id_catechumene')
            ->join('niveau_catechetiques', 'inscriptions.id_niveau', '=', 'niveau_catechetiques.id')
            ->whereIn('decisions_catechese.decision_finale', ['Cloturé', 'Abandon'])
            ->select('niveau_catechetiques.lib_niveau', 'decisions_catechese.decision_finale', DB::raw('count(*) as total'))
            ->groupBy('niveau_catechetiques.lib_niveau', 'decisions_catechese.decision_finale')
            ->get();
        return $statsAbandonClotureParNiveau;
    }

    public function pourcentageReussiteParNiveau() //calculer le pourcentage de catéchumènes ayant terminé par rapport à ceux ayant abandonné pour chaque session ou niveau
    {
        $pourcentageReussiteParNiveau = DB::table('decisions_catechese')
            ->join('inscriptions', 'decisions_catechese.id_catechumene', '=', 'inscriptions.id_catechumene')
            ->join('niveau_catechetiques', 'inscriptions.id_niveau', '=', 'niveau_catechetiques.id')
            ->select(
                'niveau_catechetiques.lib_niveau',
                DB::raw('SUM(CASE WHEN decisions_catechese.decision_finale = "Cloturé" THEN 1 ELSE 0 END) as total_cloture'),
                DB::raw('SUM(CASE WHEN decisions_catechese.decision_finale = "Abandon" THEN 1 ELSE 0 END) as total_abandon'),
                DB::raw('COUNT(*) as total_catechumenes')
            )
            ->groupBy('niveau_catechetiques.lib_niveau')
            ->get();
        return $pourcentageReussiteParNiveau;
    }

    public function statsGlobales() //Un récapitulatif global pour connaître les statistiques générales.
    {
        $statsGlobales = DB::table('decisions_catechese')
            ->select(
                DB::raw('SUM(CASE WHEN decision_finale = "Cloturé" THEN 1 ELSE 0 END) as total_cloture'),
                DB::raw('SUM(CASE WHEN decision_finale = "Abandon" THEN 1 ELSE 0 END) as total_abandon'),
                DB::raw('COUNT(*) as total_catechumenes')
            )
            ->first();
        return $statsGlobales;
    }
}