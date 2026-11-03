<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    // Auth login endpoint (Part D - Bonus)
    Route::post('login', [AuthController::class, 'login']);

    // Statistics route (Must be defined before apiResource to avoid route clash with {course})
    Route::get('courses-stats', [CourseController::class, 'stats']);

    // Course API Resource
    Route::apiResource('courses', CourseController::class);
});
