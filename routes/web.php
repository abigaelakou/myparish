<?php

use App\Http\Controllers\ArchivageController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CatecheseController;
use App\Http\Controllers\DemandeMesseController;
use App\Http\Controllers\DepensesController;
use App\Http\Controllers\DonController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\MesseController;
use App\Http\Controllers\MouvementController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ParoisseController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\TypeDonController;
use App\Http\Controllers\TypeIntentionController;
use App\Http\Controllers\TypeMesseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TypeUserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\Comparator\TypeComparator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('amd-clear-cache', function () {
    Artisan::call('config:cache');
    return Artisan::output();
});

Route::get('amd-migrate', function () {
    Artisan::call('migrate');
    return Artisan::output();
});
Route::get('welcome', function () {
    return view('welcome');
});
Route::get('/', [PresentationController::class, 'show'])->name('presentation');

Route::get('/Espaces', function () {
    return view('Espaces.template');
})->middleware(['auth', 'verified'])->name('accueil');


Route::middleware('auth')->group(function () {
    Route::view('Espaces/Admin/listeUser', 'Espaces.Admin.listeUser')->name('listeUser');
    Route::view('Espaces/Admin/listeMouvement', 'Espaces.Admin.listeMouvement')->name('listeMouvement');
    Route::view('Espaces/Admin/listeMembreMouv', 'Espaces.Admin.listeMembreMouv')->name('listeMembreMouv');
    // Affichage du formulaire
    Route::view('formTypeMesseIntention', 'Espaces.Messe.formTypeMesseIntention')->name('formTypeMesseIntention');
    // Affichage du formulaire 
    Route::view('formPaiement', 'Espaces.Messe.formPaiement')->name('formPaiement');
    Route::view('Espaces/Messe/listeDemandeMesse', 'Espaces.Messe.listeDemandeMesse')->name('listeDemandeMesse');
    Route::view('formConfirmation', 'Espaces.Messe.formConfirmation')->name('formConfirmation');
    Route::view('formTypeDon', 'Espaces.Don.formTypeDon')->name('formTypeDon');
    Route::view('listeDon', 'Espaces.Don.listeDon')->name('listeDon');
    Route::view('listeDonUtilisateur', 'Espaces.Don.listeDonUtilisateur')->name('listeDonUtilisateur');
    Route::view('formEvenement', 'Espaces.Autres.formEvenement')->name('formEvenement');
    Route::view('listEvenement', 'Espaces.Autres.listEvenement')->name('listEvenement');
    Route::view('formArchivage', 'Espaces.Autres.formArchivage')->name('formArchivage');
    Route::view('listDocArchive', 'Espaces.Autres.listDocArchive')->name('listDocArchive');
    Route::view('formCatechumene', 'Espaces.Catechese.formCatechumene')->name('formCatechumene');
    Route::view('listeCatechumene', 'Espaces.Catechese.listeCatechumene')->name('listeCatechumene');
    Route::view('espaceKT', 'Espaces.Catechese.espaceKT')->name('espaceKT');
    Route::view('showAttentePaiement', 'Espaces.Catechese.showAttentePaiement')->name('showAttentePaiement');
    Route::view('formInscriptionKT', 'Espaces.Catechese.formInscriptionKT')->name('formInscriptionKT');
    Route::view('inscriptionAttente', 'Espaces.Catechese.inscriptionAttente')->name('inscriptionAttente');
    Route::view('paiementCompleter', 'Espaces.Catechese.paiementCompleter')->name('paiementCompleter');
    Route::view('recu_paiement', 'Espaces.Catechese.recu_paiement')->name('recu_paiement');
    Route::view('partials_paiement_form', 'Espaces.Catechese.partials_paiement_form')->name('partials_paiement_form');
    Route::view('formClasse', 'Espaces.Catechese.formClasse')->name('formClasse');
    Route::get('Espaces/Catechese/formClasse', [CatecheseController::class, 'show_niv_session'])->name('formClasse');
    Route::get('Espaces/Catechese/affectation_catechumene', [CatecheseController::class, 'showForm'])->name('affectation_catechumene');
    Route::view('formDepense', 'Espaces.Depenses.formDepense')->name('formDepense');
    Route::view('listeDepense', 'Espaces.Depenses.listeDepense')->name('listeDepense');
    Route::view('listeMesDemandes', 'Espaces.Messe.listeMesDemandes')->name('listeMesDemandes');
    Route::view('changerMotPasse', 'Espaces.Admin.changerMotPasse')->name('changerMotPasse');
    Route::view('form_super_admin', 'Espaces.SuperAdmin.form_super_admin')->name('form_super_admin');
    Route::view('liste_sup_admin', 'Espaces.SuperAdmin.liste_sup_admin')->name('liste_sup_admin');
    Route::view('formAddParoisse', 'Espaces.SuperAdmin.formAddParoisse')->name('formAddParoisse');
    Route::view('liste_paroisse', 'Espaces.SuperAdmin.liste_paroisse')->name('liste_paroisse');

    // ROUTES SUPER ADMINS

    // routes utilisateurs
    Route::get('/Espaces/template', [UserController::class, 'index']);
    //Interdiction de création de super admin aux admins des paroisses
    Route::middleware(['auth', 'isSuperAdmin'])->group(function () {
        Route::post('/create_user', [UserController::class, 'create_user'])->name('create_user');
        Route::get('Espaces/Admin/formAddUser', [TypeUserController::class, 'showFormAddUser'])->name('formAddUser');
        Route::post('/create_super_admin', [ParoisseController::class, 'createSuperAdmin'])->name('create_super_admin');
        Route::post('/create_paroisse', [ParoisseController::class, 'createParoisse'])->name('create_paroisse');
        Route::get('/liste_des_super_admins', [ParoisseController::class, 'liste_des_super_admins'])->name('liste_des_super_admins');
        Route::get('/update_status_paroisse/{paroisse_id}/{status_code}', [ParoisseController::class, 'update_status_paroisse'])->name('update_status');
        Route::post('/update_paroisse', [ParoisseController::class, 'update_paroisse'])->name('update_paroisse');
        Route::get('/liste_des_paroisses', [ParoisseController::class, 'liste_des_paroisses'])->name('liste_des_paroisses');
        Route::get('/paroisses/{id}/historique', [ParoisseController::class, 'showHistorique'])->name('paroisses.historique');
        Route::get('/listUsersByParoisse', [ParoisseController::class, 'listUsersByParoisse'])->name('listUsersByParoisse');
        Route::get('/dashboardStats', [ParoisseController::class, 'dashboardStats'])->name('dashboardStats');
    });
    
        Route::get('/password/change', [PasswordChangeController::class, 'showChangeForm'])->name('password.change');
        Route::post('/password/change', [PasswordChangeController::class, 'update'])->name('password.update');


    Route::post('/check-email', [UserController::class, 'checkEmail']);
    Route::post('/update_password', [UserController::class, 'update_password'])->name('update_password');
    Route::get('/list_users', [UserController::class, 'list_users'])->name('list_users');
    Route::get('/edit_user/{id}', [UserController::class, 'edit_user'])->name('edit_user');
    Route::post('/update_user', [UserController::class, 'update_user'])->name('update_user');
    Route::get('/update_status/{user_id}/{status_code}', [UserController::class, 'update_status'])->name('update_status');
    Route::post('/statistiques', [UserController::class, 'statistiques'])->name('statistiques');
    Route::post('/updateProfileImage', [UserController::class, 'updateProfileImage'])->name('updateProfileImage');



    // Routes type utilisateurs

    // Route::get('Espaces/Admin/formAddUser', [TypeUserController::class, 'create'])->name('formAddUser');
    Route::get('Espaces/Admin/formMesse', [TypeUserController::class, 'type_utilisateur_celebrant'])->name('formMesse');

    //  Routes mouvements
    // Affichage du formulaire
    Route::view('formAddMouvement', 'Espaces.Admin.formAddMouvement')->name('formAddMouvement');
    // Route pour le stockage des mouvements
    Route::post('/create_mouvement', [MouvementController::class, 'create_mouvement'])->name('create_mouvement');
    Route::get('/liste_des_rencontres_mouvement', [MouvementController::class, 'liste_des_rencontres_mouvement'])->name('liste_des_rencontres_mouvement');
    Route::get('/edit_rencontre_mouv/{id}', [MouvementController::class, 'edit_rencontre_mouv'])->name('edit_rencontre_mouv');
    Route::post('/update_rencontre', [MouvementController::class, 'update_rencontre'])->name('update_rencontre');
    Route::get('Espaces/Admin/formAddMembreMouvement', [MouvementController::class, 'create'])->name('formAddMembreMouvement');
    Route::get('/list_membre_mouv', [MouvementController::class, 'list_membre_mouv'])->name('list_membre_mouv');
    Route::post('/create_membre_mouv', [MouvementController::class, 'create_membre_mouv'])->name('create_membre_mouv');
    Route::post('/update_membre_mouv', [MouvementController::class, 'update_membre_mouv'])->name('update_membre_mouv');
    Route::get('/supp_membre/{id}', [MouvementController::class, 'supp_membre'])->name('supp_membre');
    Route::get('Espaces/Admin/listeMembreMouv', [MouvementController::class, 'showEditMembreModal'])->name('listeMembreMouv');

    // *****************ROUTES DE MESSE**********************
    Route::post('/create_messe', [MesseController::class, 'create_messe'])->name('create_messe');
    Route::get('/liste_toutes_les_messes', [MesseController::class, 'liste_toutes_les_messes'])->name('liste_toutes_les_messes');
    Route::get('/liste_des_messes_du_celebrant', [MesseController::class, 'liste_des_messes_du_celebrant'])->name('liste_des_messes_du_celebrant');
    Route::post('/update_messe', [MesseController::class, 'update_messe'])->name('update_messe');
    Route::get('/supp_messe/{id}', [MesseController::class, 'supp_messe'])->name('supp_messe');

    Route::post('/store_demande_messe', [DemandeMesseController::class, 'store_demande_messe'])->name('store_demande_messe');
    Route::post('/update_demande_messe', [DemandeMesseController::class, 'update_demande_messe'])->name('update_demande_messe');
    Route::get('/supp_demande_messe/{id}', [DemandeMesseController::class, 'supp_demande_messe'])->name('supp_demande_messe');
    Route::get('Espaces/Messe/formDemandeMesse', [DemandeMesseController::class, 'info_type_messe'])->name('formDemandeMesse');
    Route::get('/formPaiement', [DemandeMesseController::class, 'formPaiement'])->name('formPaiement');
    Route::get('liste_demande_messe', [DemandeMesseController::class, 'liste_demande_messe'])->name('liste_demande_messe');
    Route::get('/demandes-messes-jour-suivant', [DemandeMesseController::class, 'listeDemandesMessesJourSuivant'])->name('demandes.messes.jour.suivant');
    Route::get('/generer-pdf-demandes-messes', [DemandeMesseController::class, 'genererPdfDemandesMessesJourSuivant'])->name('generer.pdf.demandes.messes');
    Route::get('/generer-word-demandes-messes', [DemandeMesseController::class, 'genererWordDemandesMessesJourSuivant'])->name('generer.word.demandes.messes');
    Route::get('/mesDemandesMesses', [DemandeMesseController::class, 'mesDemandesMesses'])->name('mesDemandesMesses');

    Route::post('/processPaiement', [PaiementController::class, 'processPaiement'])->name('processPaiement');
    Route::get('/formConfirmation', [PaiementController::class, 'confirmationPageDemande'])->name('formConfirmation');
    Route::get('paiement/{id_demande}', [PaiementController::class, 'showPaiementForm'])->name('paiement');


    Route::post('/create_type_intention', [TypeIntentionController::class, 'create_type_intention'])->name('create_type_intention');
    Route::post('/update_type_intention', [TypeIntentionController::class, 'update_type_intention'])->name('update_type_intention');
    Route::get('/supp_type_intention/{id}', [TypeIntentionController::class, 'supp_type_intention'])->name('supp_type_intention');
    Route::get('/list_type_intention', [TypeIntentionController::class, 'list_type_intention'])->name('list_type_intention');

    Route::post('/create_type_messe', [TypeMesseController::class, 'create_type_messe'])->name('create_type_messe');
    Route::post('/update_type_messe', [TypeMesseController::class, 'update_type_messe'])->name('update_type_messe');
    Route::get('/list_type_messe', [TypeMesseController::class, 'list_type_messe'])->name('list_type_messe');
    Route::get('/supp_type_messe/{id}', [TypeMesseController::class, 'supp_type_messe'])->name('supp_type_messe');

    Route::post('/create_type_don', [TypeDonController::class, 'create_type_don'])->name('create_type_don');
    Route::post('/update_type_don', [TypeDonController::class, 'update_type_don'])->name('update_type_don');
    Route::get('/list_type_don', [TypeDonController::class, 'list_type_don'])->name('list_type_don');
    Route::get('/supp_type_don/{id}', [TypeDonController::class, 'supp_type_don'])->name('supp_type_don');

    Route::get('/failed', [DonController::class, 'failedPaymentPage'])->name('failed');
    Route::post('/process', [DonController::class, 'processDonation'])->name('process');
    Route::get('/confirmation', [DonController::class, 'confirmationPage'])->name('confirmation');
    Route::get('/showDonationForm', [DonController::class, 'showDonationForm'])->name('showDonationForm');
    Route::get('Espaces/Don/formDon', [DonController::class, 'show_type_don'])->name('formDon');
    Route::get('/liste_don', [DonController::class, 'liste_don'])->name('liste_don');
    Route::get('/listUserDons', [DonController::class, 'listUserDons'])->name('listUserDons');

    Route::post('/store_evenement', [EvenementController::class, 'store_evenement'])->name('store_evenement');
    Route::post('/update_evenement', [EvenementController::class, 'update_evenement'])->name('update_evenement');
    Route::get('/liste_des_evements', [EvenementController::class, 'liste_des_evements'])->name('liste_des_evements');
    Route::get('/liste_des_evenements_non_realises', [EvenementController::class, 'liste_des_evenements_non_realises'])->name('liste_des_evenements_non_realises');
    Route::get('/supp_evenement/{id}', [EvenementController::class, 'supp_evenement'])->name('supp_evenement');

    Route::post('/store_archivage', [ArchivageController::class, 'store_archivage'])->name('store_archivage');
    Route::get('/listDocuments', [ArchivageController::class, 'listDocuments'])->name('listDocuments');

    Route::post('/store_catechumene', [CatecheseController::class, 'store_catechumene'])->name('store_catechumene');
    Route::post('/update_catechumene', [CatecheseController::class, 'update_catechumene'])->name('update_catechumene');
    Route::get('/liste_catechumene', [CatecheseController::class, 'liste_catechumene'])->name('liste_catechumene');
    Route::get('/supp_catechumene/{id}', [CatecheseController::class, 'supp_catechumene'])->name('supp_catechumene');
    Route::POST('/partials_paiement_form', [CatecheseController::class, 'completePaymentForm'])->name('partials_paiement_form');
    Route::post('/store_inscription', [CatecheseController::class, 'store_inscription'])->name('store_inscription');
    Route::post('/validation_paiementCatechese', [CatecheseController::class, 'validation_paiementCatechese'])->name('validation_paiementCatechese');
    Route::get('Espaces/Catechese/formInscriptionKT', [CatecheseController::class, 'info_catechese'])->name('formInscriptionKT');
    Route::get('inscriptionAttente/{id_inscription}', [CatecheseController::class, 'showAttentePaiement'])->name('inscriptionAttente');
    Route::get('/failedKTPaymentPage', [CatecheseController::class, 'failedKTPaymentPage'])->name('failedKTPaymentPage');
    Route::post('/paiementCompleter', [CatecheseController::class, 'completePaymentForm'])->name('paiementCompleter');
    Route::get('/getForm/{id_inscription}', [CatecheseController::class, 'getForm'])->name('getForm');

    Route::get('/download/recu/{id_paiement}', [CatecheseController::class, 'downloadRecu'])->name('download.recu');
    Route::get('/listeInscritsAttente', [CatecheseController::class, 'listeInscritsAttente'])->name('listeInscritsAttente');
    Route::get('/listeInscritsPayer', [CatecheseController::class, 'listeInscritsPayer'])->name('listeInscritsPayer');

    // Routes de classe catechèse
    Route::post('/store_classe_catechese', [CatecheseController::class, 'store_classe_catechese'])->name('store_classe_catechese');
    Route::get('/listeClasseCatechese', [CatecheseController::class, 'listeClasseCatechese'])->name('listeClasseCatechese');
    Route::post('/update_classe', [CatecheseController::class, 'update_classe'])->name('update_classe');
    Route::get('/supp_classe_catechese/{id}', [CatecheseController::class, 'supp_classe_catechese'])->name('supp_classe_catechese');
    Route::get('/liste-catechumenes', [CatecheseController::class, 'listeCatechumenesParClasse']);


    // ROUTES D'AFFECTATIONS
    Route::get('/affectation-catechumene', [CatecheseController::class, 'showForm'])->name('affectation.form');
    Route::post('/affecter-catechumene', [CatecheseController::class, 'affecterCatechumene'])->name('affecter.catechumene');
    // decision de fin d'années
    Route::post('/enregistrerDecision', [CatecheseController::class, 'enregistrerDecision'])->name('enregistrerDecision');
    Route::get('/getListeCatechumenesAvecDecisions', [CatecheseController::class, 'getListeCatechumenesAvecDecisions'])->name('getListeCatechumenesAvecDecisions');
    Route::get('Espaces/Catechese/formDecisionCatechumene', [CatecheseController::class, 'info_catechese_deux'])->name('formDecisionCatechumene');
    Route::post('/update_decision', [CatecheseController::class, 'update_decision'])->name('update_decision');
    Route::get('/getliste_catechumene_fini', [CatecheseController::class, 'getliste_catechumene_fini'])->name('getliste_catechumene_fini');

    // ROUTE DEPENSES
    Route::post('/storeDepense', [DepensesController::class, 'storeDepense'])->name('storeDepense');
    Route::get('/depenses/annee-en-cours', [DepensesController::class, 'listeDepensesAnneeEnCours']);
    Route::get('/depenses/toutes', [DepensesController::class, 'listeToutesDepenses']);
    Route::get('/listeDepensesMensuelles/{mois?}/{annee?}', [DepensesController::class, 'listeDepensesMensuelles'])->name('listeDepensesMensuelles');
    Route::get('/supp_depense/{id}', [DepensesController::class, 'supp_depense'])->name('supp_depense');
    Route::post('/update_depense', [DepensesController::class, 'update_depense'])->name('update_depense');

    // ROUTES STATISTIQUES
    Route::get('/stat_glogale', [StatistiqueController::class, 'stat_glogale'])->name('stat_glogale');
    Route::get('/stat_dons/{mois}/{annee}', [StatistiqueController::class, 'stat_dons'])->name('stat_dons');
    Route::get('/start_catechese', [StatistiqueController::class, 'start_catechese'])->name('start_catechese');
    Route::get('/start_montant_total_annee_encours', [StatistiqueController::class, 'start_montant_total_annee_encours'])->name('start_montant_total_annee_encours');



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
