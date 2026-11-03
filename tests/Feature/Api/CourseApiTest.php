<?php

namespace Tests\Feature\Api;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed 6 distinct courses for testing pagination and operations
        $courses = [
            ['code' => 'CSEB1001', 'name' => 'Intro to Programming', 'credit_hours' => 3],
            ['code' => 'CSEB1002', 'name' => 'Discrete Math', 'credit_hours' => 3],
            ['code' => 'CSEB1003', 'name' => 'Data Structures', 'credit_hours' => 4],
            ['code' => 'CSEB1004', 'name' => 'Computer Architecture', 'credit_hours' => 3],
            ['code' => 'CSEB1005', 'name' => 'Operating Systems', 'credit_hours' => 4],
            ['code' => 'CSEB1006', 'name' => 'Algorithms', 'credit_hours' => 4],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }

    public function test_can_list_courses_paginated(): void
    {
        $response = $this->getJson('/api/v1/courses');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'code', 'name', 'credit_hours', 'created_at', 'updated_at'],
                ],
                'links',
                'meta',
            ])
            ->assertJsonCount(5, 'data');
    }

    public function test_can_show_course(): void
    {
        $course = Course::first();

        $response = $this->getJson("/api/v1/courses/{$course->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $course->id,
                    'code' => $course->code,
                    'name' => $course->name,
                    'credit_hours' => $course->credit_hours,
                ],
            ]);
    }

    public function test_returns_404_for_non_existent_course(): void
    {
        $response = $this->getJson('/api/v1/courses/99999');

        $response->assertStatus(404);
    }

    public function test_can_create_course(): void
    {
        $payload = [
            'code' => 'API9999',
            'name' => 'Web API Course',
            'credit_hours' => 3,
        ];

        $response = $this->postJson('/api/v1/courses', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'code' => 'API9999',
                    'name' => 'Web API Course',
                    'credit_hours' => 3,
                ],
            ]);

        $this->assertDatabaseHas('courses', ['code' => 'API9999']);
    }

    public function test_create_course_validation_fails_with_422(): void
    {
        $payload = [
            'code' => '',
            'name' => 'Test',
            'credit_hours' => 9,
        ];

        $response = $this->postJson('/api/v1/courses', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['code', 'credit_hours']);
    }

    public function test_cannot_create_course_with_duplicate_code(): void
    {
        $course = Course::first();

        $payload = [
            'code' => $course->code,
            'name' => 'Another Course',
            'credit_hours' => 3,
        ];

        $response = $this->postJson('/api/v1/courses', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['code']);
    }

    public function test_can_update_course_credit_hours_via_patch(): void
    {
        $course = Course::first();

        $response = $this->patchJson("/api/v1/courses/{$course->id}", [
            'credit_hours' => 4,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $course->id,
                    'credit_hours' => 4,
                ],
            ]);

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'credit_hours' => 4,
        ]);
    }

    public function test_can_delete_course(): void
    {
        $course = Course::first();

        $response = $this->deleteJson("/api/v1/courses/{$course->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);

        $checkResponse = $this->getJson("/api/v1/courses/{$course->id}");
        $checkResponse->assertStatus(404);
    }

    public function test_can_get_course_statistics(): void
    {
        $response = $this->getJson('/api/v1/courses-stats');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'total_courses',
                'total_credit_hours',
                'average_credit_hours',
            ]);
    }

    public function test_search_and_filter_courses(): void
    {
        Course::create([
            'code' => 'SEARCH101',
            'name' => 'Web Application Development',
            'credit_hours' => 4,
        ]);

        $searchResponse = $this->getJson('/api/v1/courses?search=SEARCH101');
        $searchResponse->assertStatus(200);
        $this->assertTrue(collect($searchResponse->json('data'))->contains('code', 'SEARCH101'));

        $filterResponse = $this->getJson('/api/v1/courses?min_credits=4');
        $filterResponse->assertStatus(200);
        foreach ($filterResponse->json('data') as $item) {
            $this->assertGreaterThanOrEqual(4, $item['credit_hours']);
        }
    }

    public function test_auth_login_returns_token(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token', 'message', 'user']);
    }
}
