<?php

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('pipeline-jobs')->group(function () {
        Route::get('next', [Controllers\PipelineJobController::class, 'next'])
            ->middleware('abilities:reserve-job');

        Route::prefix('{job}')->group(function () {
            Route::post('/', [Controllers\PipelineJobController::class, 'update'])
                ->middleware('abilities:update-job');
        });
    });
});

Route::prefix('agents')->group(function () {
    Route::get('/', [Controllers\AgentController::class, 'index']);
    Route::post('/', [Controllers\AgentController::class, 'store']);

    Route::prefix('{agent}')->group(function () {
        Route::post('token', [Controllers\AgentController::class, 'createToken']);
    });
});
