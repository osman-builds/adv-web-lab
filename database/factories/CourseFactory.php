<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    public function definition(): array
    {
        $courses = [
            ['CSEB5123', 'Advanced Web Application Development', 3],
            ['CSEB5113', 'Software Engineering', 3],
            ['CSEB5233', 'Artificial Intelligence', 3],
            ['CSEB5313', 'Data Analytics', 3],
            ['CSEB4213', 'Database Systems', 3],
        ];

        $pick = fake()->unique()->randomElement($courses);

        return [
            'code'         => $pick[0],
            'name'         => $pick[1],
            'credit_hours' => $pick[2],
        ];
    }
}