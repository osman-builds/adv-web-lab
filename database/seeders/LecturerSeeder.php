<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use App\Models\Course;
use Illuminate\Database\Seeder;

class LecturerSeeder extends Seeder
{
    public function run(): void
    {
        $ahmad = Lecturer::firstOrCreate(
            ['staffID' => 'ST001'],
            ['name' => 'Dr. Ahmad', 'email' => 'ahmad@example.com']
        );

        $siti = Lecturer::firstOrCreate(
            ['staffID' => 'ST002'],
            ['name' => 'Dr. Siti', 'email' => 'siti@example.com']
        );

        Lecturer::firstOrCreate(
            ['staffID' => 'ST003'],
            ['name' => 'Mr. Kumar', 'email' => 'kumar@example.com']
        );

        // Assign existing courses to lecturers
        Course::where('code', 'CSNB5123')->update(['lecturer_id' => $ahmad->id]);
        Course::where('code', 'SWE3103')->update(['lecturer_id' => $ahmad->id]);
        Course::where('code', 'DS2014')->update(['lecturer_id' => $siti->id]);
    }
}