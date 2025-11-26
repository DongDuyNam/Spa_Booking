<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\BookingController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\RegisterController;

use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\StaffController;
use App\Http\Controllers\Web\CustomerController;
use App\Http\Controllers\Web\ServiceController;
use App\Http\Controllers\Web\ServicePackageController;
use App\Http\Controllers\Web\StaffScheduleController;

use App\Http\Controllers\Api\SlotController;

use App\Http\Controllers\Web\Customer\CustomerDashboardController;

/*
|--------------------------------------------------------------------------
| TRANG CHỦ + BOOKING
|--------------------------------------------------------------------------
*/
Route::get('/', [BookingController::class, 'index'])->name('home');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

/*
|--------------------------------------------------------------------------
| API SLOT CHUẨN – CHỈ DÙNG SlotController (PRO MAX)
|--------------------------------------------------------------------------
*/
Route::get('/api/slots', [SlotController::class, 'getSlots'])->name('api.slots');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

/*
|--------------------------------------------------------------------------
| ROLE-BASED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ADMIN (ROLE = 1)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:1')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

            Route::resource('customers', CustomerController::class);
            Route::resource('staffs', StaffController::class);

            Route::resource('schedules', StaffScheduleController::class)
                ->only(['index', 'store', 'update', 'destroy']);

            Route::resource('services', ServiceController::class)
                ->only(['index', 'store', 'update', 'destroy']);

            Route::resource('servicepackages', ServicePackageController::class);
        });

    /*
    |--------------------------------------------------------------------------
    | STAFF (ROLE = 2)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:2')->group(function () {
        Route::get('/staff/dashboard', [StaffController::class, 'index'])
            ->name('staff.dashboard');
    });

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER (ROLE = 3)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:3'])
        ->prefix('customer')
        ->name('customer.')
        ->group(function () {

            Route::get('/dashboard', [CustomerDashboardController::class, 'index'])
                ->name('dashboard');

            Route::get('/profile', [CustomerDashboardController::class, 'profile'])
                ->name('profile');

            Route::post('/profile/update', [CustomerDashboardController::class, 'updateProfile'])
                ->name('profile.update');

            Route::get('/appointments', [CustomerDashboardController::class, 'appointments'])
                ->name('appointments');

            // APT detail
            Route::get('/appointment/{id}', [CustomerDashboardController::class, 'apiGetAppointment'])
                ->name('appointment.api');

            // CANCEL
            Route::post('/appointments/{id}/cancel', [CustomerDashboardController::class, 'cancel'])
                ->name('appointments.cancel');

            // REBOOK
            Route::post('/appointments/{id}/rebook', [CustomerDashboardController::class, 'rebook'])
                ->name('appointments.rebook');
        });
});
