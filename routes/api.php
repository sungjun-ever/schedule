<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

Route::get('/my', [UserController::class, 'my'])
    ->middleware('auth:sanctum');

Route::prefix('/users')->group(function () {
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{userid}', [UserController::class, 'show']);
    Route::put('/{userid}', [UserController::class, 'update']);
    Route::delete('/{userid}', [UserController::class, 'destroy']);
})->middleware('auth:sanctum');