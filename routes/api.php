<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    UserController,
    BranchController,
    ServiceController,
    AppointmentController,
    PaymentController,
    ReviewController,
    PromotionController,
    NotificationController,
    LoyaltyPointController,
    StaffScheduleController,
    SystemLogController,
    AuthController
};

Route::get('/test', fn() => response()->json(['message' => 'API route active ✅']));

// ======= Public routes =======
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ======= Protected routes (require token) =======
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // CRUD protected APIs
    Route::apiResources([
        'users' => UserController::class,
        'branches' => BranchController::class,
        'services' => ServiceController::class,
        'appointments' => AppointmentController::class,
        'payments' => PaymentController::class,
        'reviews' => ReviewController::class,
        'promotions' => PromotionController::class,
        'notifications' => NotificationController::class,
        'loyaltypoints' => LoyaltyPointController::class,
        'staffschedules' => StaffScheduleController::class,
        'systemlogs' => SystemLogController::class,
    ]);
});
