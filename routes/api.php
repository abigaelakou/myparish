<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AccueilController;
use App\Http\Controllers\Api\EvenementController;
use App\Http\Controllers\Api\DonController;
use App\Http\Controllers\Api\MesseController;
use App\Http\Controllers\Api\LectureController;
use App\Http\Controllers\Api\PainJourController;
use App\Http\Controllers\Api\InscriptionCatecheseController;
use App\Http\Controllers\NotificationController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/





Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/changePassword', [AuthController::class, 'changePassword']);
    Route::post('/updateExpoToken', [AuthController::class, 'updateExpoToken']);
    

    Route::get('/accueil', [AccueilController::class, 'accueil']);
    Route::get('/evenements', [EvenementController::class, 'evenementsAvenir']);
    Route::get('/dons', [DonController::class, 'mesDons']);
    Route::post('/dons', [DonController::class, 'faireUnDon']);
    Route::get('/messes', [MesseController::class, 'mesDemandesDeMesse']);
    Route::post('/messes', [MesseController::class, 'demanderMesse']);
    Route::get('/lecture-du-jour', [LectureController::class, 'lectureDuJour']);
    Route::get('/prochaines-lectures', [LectureController::class, 'prochainesLectures']);
    Route::get('/pain-du-jour', [PainJourController::class, 'painDuJour']);
    Route::get('/derniers-pains', [PainJourController::class, 'derniersPains']); 
    Route::post('inscriptions', [InscriptionCatecheseController::class, 'store']);
    Route::get('paiement-inscription/{id}', [InscriptionCatecheseController::class, 'getPaiementInfo']);
    Route::post('paiement-inscription', [InscriptionCatecheseController::class, 'payerInscription']);
    Route::get('paiements', [InscriptionCatecheseController::class, 'listePaiements']);


    Route::post('/send-notification', [NotificationController::class, 'sendNotification']);



});

