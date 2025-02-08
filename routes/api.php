<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',

], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::post('profile', [AuthController::class, 'profile'])->middleware('auth:api');
    
});
Route::post('/api/schedules', [ScheduleController::class, 'createSchedule']);
Route::post('dept',[DepartmentController::class,'addDept']);
Route::get('dept',[DepartmentController::class,'getDepts']);
Route::post('admin/new-student', [Admin::class, 'newStudent']);
// Route::middleware('auth:api')->group(function () {
// });

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'index']);
    Route::post('/', [NotificationController::class, 'store']);
    Route::get('/{notification}', [NotificationController::class, 'show']);
    Route::put('/{notification}', [NotificationController::class, 'update']);
    Route::delete('/{notification}', [NotificationController::class, 'destroy']);
    Route::put('/{notification}/read', [NotificationController::class, 'markAsRead']);
    Route::put('/mark-all-read', [NotificationController::class, 'markAllAsRead']);
});
