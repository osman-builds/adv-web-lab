<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $mobileCourse = Course::where('code', 'CSNB5123')->first();
        $sweCourse = Course::where('code', 'SWE3103')->first();

        Student::firstOrCreate(
            ['email' => 'anim.mo@example.com'],
            ['name' => 'Anim Mo', 'course_id' => $mobileCourse?->id]
        );

        Student::firstOrCreate(
            ['email' => 'abdi.hassan@example.com'],
            ['name' => 'Abdi Hassan', 'course_id' => $sweCourse?->id]
        );
    }
}