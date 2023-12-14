<?php

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('agents')->group(function () {
        Route::get('/', [Controllers\Api\AgentController::class, 'index']);

        Route::post('/', [Controllers\Api\AgentController::class, 'store']);

        Route::post('token', [Controllers\Api\AgentController::class, 'createToken'])
            ->withoutMiddleware('auth:sanctum');
    });

    Route::prefix('pipeline-jobs')->group(function () {
        Route::post('reserve', [Controllers\PipelineJobController::class, 'reserve'])
            ->name('api.pipeline-jobs.reserve')
            ->middleware('abilities:reserve-job');

        Route::prefix('{job}')->group(function () {
            Route::post('/', [Controllers\PipelineJobController::class, 'update'])
                ->name('api.pipeline-jobs.update')
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
