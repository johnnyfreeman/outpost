<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('pipelines')->group(function () {
    Route::get('/', [Controllers\PipelineController::class, 'index'])->name('pipelines.index');
    Route::get('create', [Controllers\PipelineController::class, 'create'])->name('pipelines.create');
    Route::post('store', [Controllers\PipelineController::class, 'store'])->name('pipelines.store');

    Route::prefix('{pipeline}')->group(function () {
        Route::get('/', [Controllers\PipelineController::class, 'show'])->name('pipelines.show');
        Route::get('edit', [Controllers\PipelineController::class, 'edit'])->name('pipelines.edit');
        Route::post('update', [Controllers\PipelineController::class, 'update'])->name('pipelines.update');
    });
});
