<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;


Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // Route::post('/forgot-password', [AuthController::class, 'passwordEmail']);
    // Route::get('/reset-password/{token}', [AuthController::class, 'passwordReset'])->name('password.reset');
    // Route::post('/reset-password', [AuthController::class, 'passwordUpdate'])->name('password.update');
});

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->middleware('verified');
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('/email/resend', [AuthController::class, 'resend'])->middleware('throttle:6,1')->name('verification.send');
});

Route::middleware(['auth:api', 'verified'])->group(function () {
    Route::post('/items', [ItemController::class, 'store']);
    Route::get('/items', [ItemController::class, 'index']);
    Route::put('/items/{id}', [ItemController::class, 'update']);
    Route::delete('/items/{id}', [ItemController::class, 'destroy']);
});
