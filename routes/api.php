<?php

use Illuminate\Support\Facades\Route;


Route::get('/hello', function () {
    return response()->json([
        'message' => 'Hello API'
    ]);
});
//Route::middleware('auth:sanctum')->group(function () {
    Route::group([], __DIR__ . '/api/school-routes.php');
    Route::group([], __DIR__ . '/api/teacher-routes.php');
    Route::group([], __DIR__ . '/api/stage-routes.php');
    Route::group([], __DIR__ . '/api/class-routes.php');
    Route::group([], __DIR__ . '/api/weekly-time-table-routes.php');
    Route::group([], __DIR__ . '/api/course-routes.php');


//});

