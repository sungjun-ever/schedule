<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/auth/status', function () {
    return response()->json(['authenticated' => true], 200);
});

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware('auth:sanctum');
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/my', [UserController::class, 'my']);

    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{userid}', [UserController::class, 'show']);
        Route::put('/{userid}', [UserController::class, 'update']);
        Route::delete('/{userid}', [UserController::class, 'delete']);
    });

    Route::prefix('/teams')->group(function () {
        Route::get('/', [TeamController::class, 'index']);
        Route::post('/', [TeamController::class, 'store']);
        Route::get('/{teamId}', [TeamController::class, 'show']);
        Route::put('/{teamId}', [TeamController::class, 'update']);
        Route::delete('/{teamId}', [TeamController::class, 'delete']);
    });

    Route::prefix('/schedules')->group(function () {
        Route::get('/', [ScheduleController::class, 'index']);
        Route::get('/{scheduleId}', [ScheduleController::class, 'show']);
        Route::post('/', [ScheduleController::class, 'store']);
        Route::put('/{scheduleId}', [ScheduleController::class, 'update']);
        Route::delete('/{scheduleId}', [ScheduleController::class, 'delete']);
        Route::put('/{scheduleId}/order', [ScheduleController::class, 'updateScheduleOrder']);

        Route::prefix('/status')->group(function () {
            Route::post('/', [ScheduleController::class, 'storeStatus']);
        });
    });
});

