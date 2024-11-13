<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {
    Route::post('/items', [ItemController::class, 'store']);
    Route::get('/items', [ItemController::class, 'index']);
    Route::put('/items/{id}', [ItemController::class, 'update']);
    Route::delete('/items/{id}', [ItemController::class, 'destroy']);
});
