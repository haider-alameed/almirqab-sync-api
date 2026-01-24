<?php
use App\Http\Controllers\ClassController;
use Illuminate\Support\Facades\Route;


Route::get('/classes/classes-deleted-from-murqaib', [ClassController::class, 'getClassesDeletedFromMurqaib'])->name('stages.get_classes_deleted_from_murqaib');

Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
Route::get('/classes/list', [ClassController::class, 'list'])->name('classes.list');
Route::post('/classes/update-class-from-murqaib', [ClassController::class, 'updateClassFromMurqaib'])->name('classes.login');
Route::get('/classes/{class}', [ClassController::class, 'show'])->name('classes.show');
//Route::post('/classes', [ClassController::class, 'store'])->name('classes.store');
Route::put('/classes/{class}', [ClassController::class, 'update'])->name('classes.update');


