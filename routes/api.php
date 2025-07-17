<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\AccueilApiController;
use App\Http\Controllers\Api\CatechumeneApiController;
use App\Http\Controllers\Api\EvenementApiController;
use App\Http\Controllers\Api\DonApiController;
use App\Http\Controllers\Api\MesseApiController;
use App\Http\Controllers\Api\LectureApiController;
use App\Http\Controllers\Api\PainJourApiController;
use App\Http\Controllers\Api\InscriptionCatecheseApiController;
use App\Http\Controllers\Api\NiveauCatecheseApiController;
use App\Http\Controllers\Api\ParoisseApiController;
use App\Http\Controllers\Api\SessionCatecheseApiController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Api\TypeMesseApiController;
use App\Http\Controllers\Api\TypeIntentionApiController;


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


Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});



Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/forgot_password', [AuthApiController::class, 'forgot_password']);
Route::post('/auth/register-paroissien', [AuthApiController::class, 'registerParoissien']);


Route::get('/paroisses-actives', [ParoisseApiController::class, 'listeActives']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthApiController::class, 'user']);
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::post('/changePassword', [AuthApiController::class, 'changePassword']);
    Route::post('/updateExpoToken', [AuthApiController::class, 'updateExpoToken']);
    

    Route::get('/accueil', [AccueilApiController::class, 'accueil']);
    Route::get('/evenements', [EvenementApiController::class, 'evenementsAvenir']);

    Route::get('/mes-dons', [DonApiController::class, 'mesDons']);
    Route::post('/dons', [DonApiController::class, 'faireUnDon']);
    Route::get('/types-don', [DonApiController::class, 'getTypesDonParoisse']);


    Route::get('/type-messes/{paroisseId}', [TypeMesseApiController::class, 'TypeMesseParParoisse']);
    Route::get('/type-intentions/{paroisseId}', [TypeIntentionApiController::class, 'TypeIntentionParParoisse']);


    Route::get('/mes-demandes', [MesseApiController::class, 'mesDemandesDeMesse']);
    Route::post('/messes', [MesseApiController::class, 'demanderMesse']);
    
    Route::get('/lecture-du-jour', [LectureApiController::class, 'lectureDuJour']);
    Route::get('/prochaines-lectures', [LectureApiController::class, 'prochainesLectures']);
    
    Route::get('/pain-du-jour', [PainJourApiController::class, 'painDuJourUtilisateur']);
    Route::get('/mes-pains', [PainJourApiController::class, 'historiqueUtilisateur']);
    

    Route::post('inscriptions', [InscriptionCatecheseApiController::class, 'store']);
    Route::get('paiement-inscription/{id}', [InscriptionCatecheseApiController::class, 'getPaiementInfo']);
    Route::post('paiement-inscription', [InscriptionCatecheseApiController::class, 'payerInscription']);
    Route::get('liste-paiements', [InscriptionCatecheseApiController::class, 'listePaiements']);

    Route::get('/catechumenes/{paroisseId}', [CatechumeneApiController::class, 'index']);
    Route::get('/niveaux-catechetiques', [NiveauCatecheseApiController::class, 'index']);
    Route::get('/sessions-catechese', [SessionCatecheseApiController::class, 'index']);


    Route::post('/send-notification', [NotificationController::class, 'sendNotification']);



});