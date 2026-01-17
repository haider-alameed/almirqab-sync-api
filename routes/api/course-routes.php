<?php
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/list', [CourseController::class, 'list'])->name('courses.list');
Route::post('/courses/update-course-from-murqaib', [CourseController::class, 'updateCourseFromMurqaib'])->name('courses.login');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
//Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');


