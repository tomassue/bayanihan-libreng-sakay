<?php

use App\Http\Controllers\GenerateClientQRController;
use App\Http\Controllers\HomeController;
use App\Livewire\OrganizationDetails;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\RegistrationAccountTypeController;
use App\Http\Controllers\LandingPageController;
use App\Livewire\ChangePassword;
use App\Livewire\Dashboard;
use App\Livewire\EventDetails;
use App\Livewire\Registration;
use App\Livewire\Events;
use App\Livewire\Reports;
use App\Livewire\UpdateProfile;

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

Route::get('/', function () {
    return view('auth.login'); // I changed this from welcome, making the login page as landing page of the system.
});

// Route::get('/success-page', [LandingPageController::class, 'index'])->name('landing-page');

// This is somehow the 'landing page' of registration. Users are asked what account type they are going to register, then they will be routed to the registration form associated with the account type they prefer.
// Route::post('/registration', [RegistrationAccountTypeController::class, 'index'])->name('registration');
// Route::get('/registration/org', [RegistrationAccountTypeController::class, 'registerOrg'])->name('register.org');

Route::get('/registration/ind', [RegistrationAccountTypeController::class, 'registerInd'])->name('register.ind');

// Route::get('/registration/client', [RegistrationAccountTypeController::class, 'registerClient'])->name('register.client');

Route::get('/qr/{ClientUserID}', [GenerateClientQRController::class, 'generateQRPage'])->name('qr'); // QR PAGE
Route::get('/get-my-qr/client/{ClientUserID}', [GenerateClientQRController::class, 'index'])->name('get-my-qr'); // GENERATE QR

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    // Your authenticated routes go here
    Route::get('/change-password', ChangePassword::class)->name('change-password');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/registration', Registration::class)->name('registration');
    Route::get('/events', Events::class)->name('events');

    Route::get('/registration/organization-details/{id_organization}', OrganizationDetails::class)->name('organization.details');
    Route::get('/registration/event-details/{eventID}', EventDetails::class)->name('event-details');

    Route::get('/update-profile/{id}', UpdateProfile::class)->name('update.profile');

    Route::get('/client-list', Reports::class)->name('client-list');
    Route::get('/generate-qr/{clientID}', [Reports::class, 'generateQr'])->name('generate.qr');
});
