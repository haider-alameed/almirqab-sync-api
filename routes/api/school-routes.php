<?php
use App\Http\Controllers\SchoolController;
use Illuminate\Support\Facades\Route;

Route::get('/schools', [SchoolController::class, 'index'])->name('schools.index');
Route::get('/schools/list', [SchoolController::class, 'list'])->name('schools.list');
Route::post('/schools/update-school-from-murqaib', [SchoolController::class, 'updateSchoolFromMurqaib'])->name('schools.login');
Route::get('/schools/{school}', [SchoolController::class, 'show'])->name('schools.show');
//Route::post('/schools', [SchoolController::class, 'store'])->name('schools.store');
Route::put('/schools/{school}', [SchoolController::class, 'update'])->name('schools.update');


