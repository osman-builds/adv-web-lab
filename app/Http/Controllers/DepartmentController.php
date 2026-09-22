<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        // Eager-load students so we can count them without the N+1 problem
        $departments = Department::with('students.courses')->get();
        return view('departments.index', compact('departments'));
    }
}