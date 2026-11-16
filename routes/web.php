<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Resource routes for the student portal
Route::resource('departments', DepartmentController::class);
Route::resource('students', StudentController::class);
Route::resource('courses', CourseController::class);
Route::resource('lecturers', LecturerController::class);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Chat routes (CampusBuddy)
Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])
        ->name('chat.index');
    Route::post('/chat', [ChatController::class, 'store'])
        ->name('chat.store')->middleware('throttle:15,1'); // 15 per minute
    Route::post('/chat/send', [ChatController::class, 'send'])
        ->name('chat.send')->middleware('throttle:15,1'); // Part E
    Route::get('/chat/{conversation}', [ChatController::class, 'index'])
        ->name('chat.show');
});
