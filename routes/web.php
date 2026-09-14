<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\StudentController;
Route::get('/lab-test', [TestController::class, 'index']);

Route::get('/', function () {
    return view('welcome');
});

Route::resource('students', StudentController::class);