<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LecturerController;

Route::get('/', function () {
    return view('welcome');
});

// Resource routes for the student portal
Route::resource('departments', DepartmentController::class);
Route::resource('students', StudentController::class);
Route::resource('courses', CourseController::class);
Route::resource('lecturers', LecturerController::class);