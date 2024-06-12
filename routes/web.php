<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;

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


Route::GET('/', [EmailController::class, 'getPageLogin'])
->name('pageLogin');

Route::POST('/login', [EmailController::class, 'login'])
->name('login');

Route::GET('/boiteReception', [EmailController::class, 'getBoiteReception'])
->name('boiteReception');

Route::GET('/detailsReception', [EmailController::class, 'getDetailsReception'])
->name('detailsReception');


Route::POST('/repondreEmail', [EmailController::class, 'repondreEmail'])
->name('repondreEmail');

Route::GET('/spam', [EmailController::class, 'getSpam'])
->name('spam');

Route::GET('/envoye', [EmailController::class, 'getEnvoye'])
->name('envoye');

Route::GET('/newMessage', [EmailController::class, 'getNewMessage'])
->name('newMessage');

Route::POST('/sendMessage', [EmailController::class, 'sendMessage'])
->name('sendMessage');

Route::GET('/deconnect', [EmailController::class, 'deconnect'])
->name('deconnect');

Route::GET('/getProfileConnected', [EmailController::class, 'getProfileConnected'])
->name('getProfileConnected');

Route::GET('/detailsEnvoi', [EmailController::class, 'getDetailsEnvoi'])
->name('detailsEnvoi');

Route::GET('/signaleSpam', [EmailController::class, 'signaleSpam'])
->name('signaleSpam');

Route::GET('/signaleNoSpam', [EmailController::class, 'signaleNoSpam'])
->name('signaleNoSpam');

Route::GET('/getUpdate', [EmailController::class, 'getUpdate'])
->name('getUpdate');

Route::GET('/update', [EmailController::class, 'update'])
->name('update');

Route::GET('/testCorrection', [EmailController::class, 'testCorrection'])
->name('testCorrection');

Route::GET('/suggestions', [EmailController::class, 'getSuggestions'])
->name('suggestions');