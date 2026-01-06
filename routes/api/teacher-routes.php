<?php
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
Route::get('/teachers/list', [TeacherController::class, 'list'])->name('teachers.list');
Route::post('/teachers/update-teacher-from-murqaib', [TeacherController::class, 'updateTeacherFromMurqaib'])->name('teachers.login');
Route::get('/teachers/{teacher}', [TeacherController::class, 'show'])->name('teachers.show');
//Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
Route::put('/teachers/{teacher}', [TeacherController::class, 'update'])->name('teachers.update');


