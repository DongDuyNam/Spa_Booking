<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\BookingController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\RegisterController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\AdminAppointmentController;
use App\Http\Controllers\Web\StaffController;
use App\Http\Controllers\Web\CustomerController;
use App\Http\Controllers\Web\ServiceController;
use App\Http\Controllers\Web\ServicePackageController;
use App\Http\Controllers\Web\StaffScheduleController;
use App\Http\Controllers\Web\PromotionController;
use App\Http\Controllers\Web\ReviewController;

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
| API SLOT
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
    |----------------------------------------------------------------------
    | ADMIN (ROLE = 1)
    |----------------------------------------------------------------------
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

            Route::resource('promotions', PromotionController::class);

            Route::get(
                'promotions/{promotion}/toggle',
                [PromotionController::class, 'toggle']
            )->name('promotions.toggle');

            Route::resource('reviews', ReviewController::class);

            Route::get(
                'reviews/{review}/toggle',
                [ReviewController::class, 'toggle']
            )->name('reviews.toggle');

            Route::post(
                'reviews/{review}/reply',
                [ReviewController::class, 'reply']
            )->name('reviews.reply');

            /*
            |--------------------------------------------------------------
            | APPOINTMENTS - LỊCH HẸN
            |--------------------------------------------------------------
            */
            Route::resource('appointments', AdminAppointmentController::class)
                ->only(['index', 'update']);


            Route::post(
                'appointments/{appointment}/cancel',
                [AdminAppointmentController::class, 'cancel']
            )->name('appointments.cancel');

            Route::post(
                'appointments/{appointment}/assign',
                [AdminAppointmentController::class, 'assign']
            )->name('appointments.assign');

            // ✅ AJAX: Lấy nhân viên có lịch làm theo ngày
            Route::get(
                'appointments/staff-by-date/{date}',
                [AdminAppointmentController::class, 'getStaffByDate']
            )->name('appointments.staffByDate');

            Route::get(
                'appointments/available-staff',
                [AdminAppointmentController::class, 'getAvailableStaff']
            )->name('appointments.availableStaff');

            Route::get(
                'appointments/{appointment}/available-staff',
                [AdminAppointmentController::class, 'getAvailableStaff']
            )->name('appointments.availableStaff');
        });

    /*
    |----------------------------------------------------------------------
    | STAFF (ROLE = 2)
    |----------------------------------------------------------------------
    */
    Route::middleware('role:2')->group(function () {
        Route::get('/staff/dashboard', [StaffController::class, 'index'])
            ->name('staff.dashboard');
    });

    /*
    |----------------------------------------------------------------------
    | CUSTOMER (ROLE = 3)
    |----------------------------------------------------------------------
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

            // DETAIL
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
