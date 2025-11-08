<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\StaffController;
use App\Http\Controllers\Web\CustomerController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\RegisterController;
use App\Http\Controllers\Web\ScheduleController;
use App\Http\Controllers\Web\BookingController;

// Trang chủ
Route::get('/', function () {
    return view('home');
})->name('home');

// ================== AUTH ==================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


Route::get('/', [BookingController::class, 'index'])->name('home');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');


// ================== DASHBOARD (SAU KHI LOGIN) ==================
Route::middleware('auth')->group(function () {

    // Admin dashboard
    Route::middleware('role:1')->get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Staff dashboard
    Route::middleware('role:2')->get('/staff/dashboard', [StaffController::class, 'index'])->name('staff.dashboard');

    // Customer dashboard
    Route::middleware('role:3')->get('/customer/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');
});

// ================== QUẢN LÝ (ADMIN ONLY) ==================
// ================== QUẢN LÝ (ADMIN ONLY) ==================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:1'])
    ->group(function () {
        Route::resource('customers', \App\Http\Controllers\Web\CustomerController::class);
        Route::resource('staffs', \App\Http\Controllers\Web\StaffController::class);
        Route::resource('schedule', \App\Http\Controllers\Web\ScheduleController::class)
              ->only(['index', 'create', 'store', 'destroy']);
    });


