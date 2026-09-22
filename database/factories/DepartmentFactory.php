<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Computer Science',
                'Software Engineering',
                'Information Technology',
                'Data Science',
            ]),
            'code' => fake()->unique()->regexify('[A-Z]{2,3}'),
        ];
    }
}