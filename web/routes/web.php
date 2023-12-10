<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::middleware('auth.basic')->group(function () {
    Route::redirect('/', 'pipelines')->name('home');

    Route::prefix('pipelines')->group(function () {
        Route::get('/', [Controllers\PipelineController::class, 'index'])->name('pipelines.index');
        Route::get('create', [Controllers\PipelineController::class, 'create'])->name('pipelines.create');
        Route::post('store', [Controllers\PipelineController::class, 'store'])->name('pipelines.store');

        Route::prefix('{pipeline}')->group(function () {
            Route::get('/', [Controllers\PipelineController::class, 'show'])->name('pipelines.show');
            Route::get('edit', [Controllers\PipelineController::class, 'edit'])->name('pipelines.edit');
            Route::post('update', [Controllers\PipelineController::class, 'update'])->name('pipelines.update');
            Route::post('run', [Controllers\PipelineController::class, 'run'])->name('pipelines.run');

            Route::prefix('steps')->group(function () {
                Route::prefix('{step}')->scopeBindings()->group(function () {
                    Route::post('run', [Controllers\PipelineController::class, 'runStep'])->name('pipelines.steps.run');
                });
            });
        });
    });
});
