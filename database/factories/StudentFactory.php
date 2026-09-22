<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'          => fake()->name(),
            'matric_no'     => fake()->unique()->numerify('CS######'),
            'email'         => fake()->unique()->safeEmail(),
            'department_id' => Department::inRandomOrder()->first()?->id ?? 1,
        ];
    }
}