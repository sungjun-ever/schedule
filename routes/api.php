<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/auth/status', function () {
    return response()->json(['authenticated' => true], 200);
});


Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

Route::get('/my', [UserController::class, 'my'])
    ->middleware('auth:sanctum');

Route::prefix('/users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{userid}', [UserController::class, 'show']);
    Route::put('/{userid}', [UserController::class, 'update']);
    Route::delete('/{userid}', [UserController::class, 'destroy']);
});