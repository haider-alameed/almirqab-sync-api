<?php
use App\Http\Controllers\WeeklyTimetableController;
use Illuminate\Support\Facades\Route;

Route::get('/weekly-timetable', [WeeklyTimetableController::class, 'index'])->name('weekly_timetables.index');
Route::get('/weekly-timetable/list', [WeeklyTimetableController::class, 'list'])->name('weekly_timetables.list');
Route::post('/weekly-timetable/update-weekly-timetable-from-murqaib', [WeeklyTimetableController::class, 'updateWeeklyTimetableFromMurqaib'])->name('weekly_timetables.update');
Route::get('/weekly-timetable/{weeklyTimetable}', [WeeklyTimetableController::class, 'show'])->name('weekly_timetables.show');
//Route::post('/weekly-timetable', [WeeklyTimetableController::class, 'store'])->name('weekly-timetable.store');
Route::put('/weekly-timetable/{weeklyTimetable}', [WeeklyTimetableController::class, 'update'])->name('weekly_timetables.update');


