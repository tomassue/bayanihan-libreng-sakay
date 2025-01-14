<?php

use App\Http\Controllers\GenerateClientQRController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\UpdatedPassword;
use App\Livewire\AttendanceReport;
use App\Livewire\EventsReport;
use App\Livewire\NewProcess\UserManagement;
use App\Livewire\OrganizationDetails;
use App\Livewire\OrgReports;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\RegistrationAccountTypeController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\AdminAndOrg;
use App\Http\Middleware\DefaultPassword;
use App\Http\Middleware\NPSuperAdminAndAdminOnly;
use App\Livewire\ChangePassword;
use App\Livewire\ClientsReport;
use App\Livewire\Dashboard;
use App\Livewire\EventDetails;
use App\Livewire\Registration;
use App\Livewire\Events;
use App\Livewire\IndiReports;
use App\Livewire\NewProcess\Events as NewProcessEvents;
use App\Livewire\NewProcess\Registration as NewProcessRegistration;
use App\Livewire\NewProcess\RegistrationRider;
use App\Livewire\References;
use App\Livewire\Reports;
use App\Livewire\RidersReports;
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

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/success-page', [LandingPageController::class, 'index'])->name('landing-page');

// This is somehow the 'landing page' of registration. Users are asked what account type they are going to register, then they will be routed to the registration form associated with the account type they prefer.
// Route::post('/registration', [RegistrationAccountTypeController::class, 'index'])->name('registration');
Route::get('/registration/ind', [RegistrationAccountTypeController::class, 'registerInd'])->name('register.ind');
// Route::get('/registration/org', [RegistrationAccountTypeController::class, 'registerOrg'])->name('register.org');
// Route::get('/registration/client', [RegistrationAccountTypeController::class, 'registerClient'])->name('register.client');

Route::group(['middleware' => ['auth', 'BlockAccess']], function () {
    Route::get('/qr/{ClientUserID}', [GenerateClientQRController::class, 'generateQRPage'])->name('qr'); // QR PAGE
    Route::get('/get-my-qr/client/{ClientUserID}', [GenerateClientQRController::class, 'index'])->name('get-my-qr'); // GENERATE QR
});

Auth::routes();

Route::group(['middleware' => 'auth', DefaultPassword::class], function () {
    Route::get('/change-password', ChangePassword::class)->name('change-password');
});

# Both the Admin and Organization can access these routes
Route::group(['middleware' => ['auth', AdminAndOrg::class, UpdatedPassword::class, 'BlockAccess']], function () {
    // Your authenticated routes go here
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/registration', Registration::class)->name('registration');
    Route::get('/events', Events::class)->name('events');

    Route::get('/registration/organization-details/{id_organization}', OrganizationDetails::class)->name('organization.details');
    Route::get('/registration/event-details/{eventID}', EventDetails::class)->name('event-details');

    Route::get('/update-profile', UpdateProfile::class)->name('update.profile');

    // REPORTS (ADMIN)
    Route::get('/event-reports', EventsReport::class)->name('event-reports');
    Route::get('/client-reports', ClientsReport::class)->name('client-reports');
    Route::get('/org-reports', OrgReports::class)->name('org-reports');
    Route::get('/rider-reports', RidersReports::class)->name('rider-reports');

    // REPORTS GENERATE PDF
    Route::get('/pdf-report-clients/{start_date?}/{end_date?}/{search_client?}', [Reports::class, 'printPDF'])->name('pdf-report-clients');
    Route::get('/pdf-events/{start_date?}/{end_date?}/{query_event?}', [EventsReport::class, 'printPDF'])->name('pdf-events');
    Route::get('/pdf-clients/{start_date?}/{end_date?}/{acct_type?}/{query_event?}', [ClientsReport::class, 'printPDF'])->name('pdf-clients');
    Route::get('/pdf-org/{start_date?}/{end_date?}', [OrgReports::class, 'printPDF'])->name('pdf-org');
    Route::get('/pdf-riders/{start_date?}/{end_date?}/{query_org?}', [RidersReports::class, 'printPDF'])->name('pdf-riders');
    Route::get('/pdf-attendance/{query?}', [AttendanceReport::class, 'printPDF'])->name('pdf-attendance');

    // REPORTS (ORGANIZATION)
    Route::get('/indi-reports', IndiReports::class)->name('indi-reports');
    Route::get('/attendance-reports', AttendanceReport::class)->name('attendance-reports');

    // REPORTS GENERATE PDF (ORGANIZATION)
    Route::get('/pdf-indi/{search_rider?}', [IndiReports::class, 'printPDF'])->name('pdf-indi');

    Route::get('/client-list', Reports::class)->name('client-list');
    Route::get('/generate-qr/{clientID}', [Reports::class, 'generateQr'])->name('generate.qr');
});

# Only Admin can access these routes
Route::group(['middleware' => ['auth', Admin::class, UpdatedPassword::class]], function () {
    // REFERENCE
    Route::get('/references', References::class)->name('references');
});


/* -------------------------------------------------------------------------- */
/*                                 NEW PROCESS                                */
/* -------------------------------------------------------------------------- */

Route::group(['middleware' => ['auth', AdminAndOrg::class, UpdatedPassword::class]], function () {
    Route::get('/np/registration', NewProcessRegistration::class)->name('np_registration');
    Route::get('/np/register-rider', RegistrationRider::class)->name('register-rider');
    Route::get('/np/events', NewProcessEvents::class)->name('np_events');
});

Route::group(['middleware' => ['auth', AdminAndOrg::class, UpdatedPassword::class, NPSuperAdminAndAdminOnly::class]], function () {
    Route::get('np/settings/user-management', UserManagement::class)->name('np_user_management');
});


/* ------------------------------- FOR SERVER ------------------------------- */

// Livewire::setScriptRoute(function ($handle) {
//     return Route::get('/libreng-sakay/livewire/livewire.js', $handle);
// });
// Livewire::setUpdateRoute(function ($handle) {
//     return Route::post('/libreng-sakay/livewire/update', $handle);
// });