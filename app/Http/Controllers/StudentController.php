<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // Load all students with their department and enrolled courses
        $students = Student::with(['department', 'courses'])->get();

        return view('students.index', compact('students'));
    }
}