<?php

use Illuminate\Support\Facades\Route;


Route::get('/hello', function () {
    return response()->json([
        'message' => 'Hello API'
    ]);
});
//Route::middleware('auth:sanctum')->group(function () {
    Route::group([], __DIR__ . '/api/school-routes.php');


//});

