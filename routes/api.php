<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TeamController;
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
    Route::delete('/{userid}', [UserController::class, 'delete']);
})->middleware('auth:sanctum');


Route::prefix('/teams')->group(function () {
    Route::get('/', [TeamController::class, 'index']);
    Route::post('/', [TeamController::class, 'store']);
    Route::get('/{teamid}', [TeamController::class, 'show']);
    Route::put('/{teamid}', [TeamController::class, 'update']);
})->middleware('auth:sanctum');

Route::prefix('/schedules')->group(function () {
   Route::post('/', [ScheduleController::class, 'store']);

   Route::prefix('/status')->group(function () {
      Route::post('/', [ScheduleController::class, 'storeStatus']);
   });
})->middleware('auth:sanctum');