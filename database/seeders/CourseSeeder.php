<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            ['code' => 'CSNB5123', 'name' => 'Mobile Application Development', 'credit_hours' => 3],
            ['code' => 'SWE3103',  'name' => 'Software Architecture',          'credit_hours' => 3],
            ['code' => 'DS2014',   'name' => 'Data Engineering & Analytics',    'credit_hours' => 3],
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate(['code' => $course['code']], $course);
        }
    }
}