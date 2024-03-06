<?php

use App\Http\Controllers\Api\ClientListController;
use App\Http\Controllers\Api\EventsController;
use App\Http\Controllers\Api\HomeScreenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RidersListController;
use App\Http\Controllers\Api\TransactionsController;
use App\Http\Controllers\Api\NumberMessageController;
use App\Models\NumberMessageModel;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegistrationController::class, 'register']);
Route::get('/school', [RegistrationController::class, 'getSchool']);
Route::get('/profile/{token}', [ProfileController::class, 'index']);
Route::get('/get_qr/{token}', [ProfileController::class, 'generateQRCode']);
Route::get('/list-of-events/{token}', [EventsController::class, 'index']);
Route::post('/join-event', [EventsController::class, 'joinEvent']);
Route::get('/joined-events/{token}', [EventsController::class, 'joinedEvents']);
Route::get('/client-list/{token}', [ClientListController::class, 'index']);
Route::get('/riders-list/{token}', [RidersListController::class, 'index']);
Route::post('/transact', [TransactionsController::class, 'transaction']);
Route::post('/drop', [TransactionsController::class, 'dropClient']);
Route::get('/check-user/{token}', [LoginController::class, 'checkUser']);

// Change Password
Route::get('/check-contact-number/{contact_number}', [NumberMessageController::class, 'store']);
Route::post('/check-contact-otp', [NumberMessageController::class, 'verify_otp']);
Route::post('/change-password', [NumberMessageController::class, 'new_password']);
