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
            ['code' => 'CSNB5123', 'title' => 'Mobile Application Development'],
            ['code' => 'SWE3103',  'title' => 'Software Architecture'],
            ['code' => 'DS2014',   'title' => 'Data Engineering & Analytics'],
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate(['code' => $course['code']], $course);
        }
    }
}