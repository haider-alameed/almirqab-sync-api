<?php
use App\Http\Controllers\StageController;
use Illuminate\Support\Facades\Route;

Route::get('/stages', [StageController::class, 'index'])->name('stages.index');
Route::get('/stages/list', [StageController::class, 'list'])->name('stages.list');
Route::post('/stages/update-stage-from-murqaib', [StageController::class, 'updateStageFromMurqaib'])->name('stages.login');
Route::get('/stages/{stage}', [StageController::class, 'show'])->name('stages.show');
//Route::post('/stages', [StageController::class, 'store'])->name('stages.store');
Route::put('/stages/{stage}', [StageController::class, 'update'])->name('stages.update');


