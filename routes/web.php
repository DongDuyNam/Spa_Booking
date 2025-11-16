<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\StaffController;
use App\Http\Controllers\Web\CustomerController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\RegisterController;
use App\Http\Controllers\Web\StaffScheduleController;
use App\Http\Controllers\Web\BookingController;
use App\Http\Controllers\Web\ServiceController;
use App\Http\Controllers\Web\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Web\Customer\DashboardController as CustomerDashboardController;

/*
|--------------------------------------------------------------------------
| Trang chủ + Đặt lịch
|--------------------------------------------------------------------------
*/

Route::get('/', [BookingController::class, 'index'])->name('home');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

/*
|--------------------------------------------------------------------------
| AUTH (Đăng nhập / Đăng ký / Đăng xuất)
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

/*
|--------------------------------------------------------------------------
| DASHBOARD (Tùy theo role)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // ----------------- ADMIN -----------------
    Route::middleware('role:1')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

            // Quản lý khách hàng (admin)
            Route::resource('customers', CustomerController::class);

            // Quản lý nhân viên
            Route::resource('staffs', StaffController::class);

            // Quản lý lịch làm việc
            Route::resource('schedules', StaffScheduleController::class)
                ->only(['index', 'store', 'update', 'destroy']);

            // Quản lý dịch vụ
            Route::resource('services', ServiceController::class)
                ->only(['index', 'store', 'update', 'destroy']);

            // Xuất lich excel
            Route::get('schedules-export', [StaffScheduleController::class, 'export'])
                ->name('admin.schedules.export');
        });

    // ----------------- STAFF -----------------
    Route::middleware('role:2')->group(function () {
        Route::get('/staff/dashboard', [StaffController::class, 'index'])->name('staff.dashboard');
    });

    // ----------------- CUSTOMER -----------------
    // Route::middleware('role:3')->group(function () {
    //     Route::get('/customer/dashboard', [CustomerDashboardController::class, 'index'])
    //         ->name('customer.dashboard');
    // });



});
