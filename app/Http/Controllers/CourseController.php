<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        // withCount adds a students_count property efficiently via subquery
        $courses = Course::withCount('students')->get();
        return view('courses.index', compact('courses'));
    }
}