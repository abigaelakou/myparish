<?php

use App\Http\Controllers\ArchivageController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DemandeMesseController;
use App\Http\Controllers\DonController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\MesseController;
use App\Http\Controllers\MouvementController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProfileController;
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
Route::get('/', function () {
    return view('welcome');
});


Route::get('/Espaces', function () {
    return view('Espaces.template');
})->middleware(['auth', 'verified'])->name('accueil');

// INSERT INTO type_messes (lib_type_messe) VALUES ('Messe de Réparation'), ('Messe de Repos'), ('Messe de Grâce');
// INSERT INTO type_intentions (lib_type_intention) VALUES ('Pour les défunts'), ('Pour les malades'), ('Pour la paix');

Route::middleware('auth')->group(function () {
    Route::view('Espaces/Admin/listeUser', 'Espaces.Admin.listeUser')->name('listeUser');
    Route::view('Espaces/Admin/listeMouvement', 'Espaces.Admin.listeMouvement')->name('listeMouvement');
    Route::view('Espaces/Admin/listeMembreMouv', 'Espaces.Admin.listeMembreMouv')->name('listeMembreMouv');
    // Affichage du formulaire
    Route::view('formTypeMesseIntention', 'Espaces.Messe.formTypeMesseIntention')->name('formTypeMesseIntention');
    // Affichage du formulaire 
    Route::view('formPaiement', 'Espaces.Messe.formPaiement')->name('formPaiement');
    Route::view('Espaces/Messe/listeDemandeMesse', 'Espaces.Messe.listeDemandeMesse')->name('listeDemandeMesse');
    Route::view('formTypeDon', 'Espaces.Don.formTypeDon')->name('formTypeDon');
    Route::view('listeDon', 'Espaces.Don.listeDon')->name('listeDon');
    Route::view('listeDonUtilisateur', 'Espaces.Don.listeDonUtilisateur')->name('listeDonUtilisateur');
    Route::view('formEvenement', 'Espaces.Autres.formEvenement')->name('formEvenement');
    Route::view('listEvenement', 'Espaces.Autres.listEvenement')->name('listEvenement');
    Route::view('formArchivage', 'Espaces.Autres.formArchivage')->name('formArchivage');
    Route::view('listDocArchive', 'Espaces.Autres.listDocArchive')->name('listDocArchive');

    // routes utilisateurs
    Route::post('/create_user', [UserController::class, 'create_user'])->name('create_user');
    Route::post('/check-email', [UserController::class, 'checkEmail']);
    Route::post('/update_password', [UserController::class, 'update_password'])->name('update_password');
    Route::get('/list_users', [UserController::class, 'list_users'])->name('list_users');
    Route::get('/edit_user/{id}', [UserController::class, 'edit_user'])->name('edit_user');
    Route::post('/update_user', [UserController::class, 'update_user'])->name('update_user');
    Route::get('/update_status/{user_id}/{status_code}', [UserController::class, 'update_status'])->name('update_status');
    Route::post('/statistiques', [UserController::class, 'statistiques'])->name('statistiques');

    // Routes type utilisateurs

    Route::get('Espaces/Admin/formAddUser', [TypeUserController::class, 'create'])->name('formAddUser');
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


    Route::post('/processPaiement', [PaiementController::class, 'processPaiement'])->name('processPaiement');
    Route::get('/confirmation', [PaiementController::class, 'confirmationPage'])->name('confirmation');
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
    Route::get('/formDon', [DonController::class, 'showDonationForm'])->name('formDon');
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


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
