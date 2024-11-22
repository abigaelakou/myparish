<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\MouvementController;
use App\Http\Controllers\ProfileController;
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


Route::middleware('auth')->group(function () {
    Route::view('Espaces/Admin/listeUser', 'Espaces.Admin.listeUser')->name('listeUser');
    Route::view('Espaces/Admin/listeMouvement', 'Espaces.Admin.listeMouvement')->name('listeMouvement');
    Route::view('Espaces/Admin/listeMembreMouv', 'Espaces.Admin.listeMembreMouv')->name('listeMembreMouv');

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

    //  Routes mouvements
    // Affichage du formulaire
    Route::view('formAddMouvement', 'Espaces.Admin.formAddMouvement')->name('formAddMouvement');
    // Route pour le stockage des mouvements
    Route::post('/store', [MouvementController::class, 'store'])->name('store');
    Route::get('/liste_des_rencontres_mouvement', [MouvementController::class, 'liste_des_rencontres_mouvement'])->name('liste_des_rencontres_mouvement');
    Route::get('/edit_rencontre_mouv/{id}', [MouvementController::class, 'edit_rencontre_mouv'])->name('edit_rencontre_mouv');
    Route::post('/update_rencontre', [MouvementController::class, 'update_rencontre'])->name('update_rencontre');
    Route::get('Espaces/Admin/formAddMembreMouvement', [MouvementController::class, 'create'])->name('formAddMembreMouvement');
    Route::get('/list_membre_mouv', [MouvementController::class, 'list_membre_mouv'])->name('list_membre_mouv');
    Route::post('/create_membre_mouv', [MouvementController::class, 'create_membre_mouv'])->name('create_membre_mouv');
    Route::post('/update_membre_mouv', [MouvementController::class, 'update_membre_mouv'])->name('update_membre_mouv');
    Route::get('/supp_membre/{id}', [MouvementController::class, 'supp_membre'])->name('supp_membre');
    Route::get('Espaces/Admin/listeMembreMouv', [MouvementController::class, 'showEditMembreModal'])->name('listeMembreMouv');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';