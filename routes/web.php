<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LecturerController;
Route::get('/lab-test', [TestController::class, 'index']);

Route::get('/', function () {
    return view('welcome');
});

Route::resource('students', StudentController::class);
Route::resource('lecturers', LecturerController::class);