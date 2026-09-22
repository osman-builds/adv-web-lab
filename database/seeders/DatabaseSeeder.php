<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create 4 departments
        Department::factory()->count(4)->create();

        // 2. Create 20 students (each assigned to a random department)
        Student::factory()->count(20)->create();

        // 3. Create 5 courses
        Course::factory()->count(5)->create();

        // 4. Enrol each student in 1-3 random courses
        $students = Student::all();
        $courses = Course::all();

        foreach ($students as $student) {
            $randomCourses = $courses->random(rand(1, 3))->pluck('id');

            $student->courses()->attach(
                $randomCourses->mapWithKeys(fn($id) => [
                    $id => ['enrolled_at' => now(), 'grade' => null]
                ])->toArray()
            );
        }
    }
}