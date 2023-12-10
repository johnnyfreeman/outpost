<?php

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('agents')->group(function () {
        Route::get('/', [Controllers\AgentController::class, 'index']);

        Route::post('/', [Controllers\AgentController::class, 'store']);

        Route::post('token', [Controllers\AgentController::class, 'createToken'])
            ->withoutMiddleware('auth:sanctum');
    });

    Route::prefix('pipeline-jobs')->group(function () {
        Route::get('next', [Controllers\PipelineJobController::class, 'next'])
            ->middleware('abilities:reserve-job');

        Route::prefix('{job}')->group(function () {
            Route::post('/', [Controllers\PipelineJobController::class, 'update'])
                ->middleware('abilities:update-job');
        });
    });

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::prefix('webhooks')->group(function () {
    Route::webhooks('github', 'github');
});
