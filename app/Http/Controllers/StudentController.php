<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // with('course') eager loads the relationship to prevent N+1 queries
        $students = Student::with('course')->get();
        $courses = Course::all();

        return view('students.index', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:students,email',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        Student::create($validated);

        return redirect()->route('students.index');
    }

    public function edit(string $id)
    {
        $student = Student::findOrFail($id);
        $courses = Course::all();

        return view('students.edit', compact('student', 'courses'));
    }

    public function update(Request $request, string $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:students,email,' . $student->id,
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $student->update($validated);

        return redirect()->route('students.index');
    }

    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index');
    }
}