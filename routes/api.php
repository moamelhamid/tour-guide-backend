<?php

use App\Http\Controllers\AuthController;
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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
