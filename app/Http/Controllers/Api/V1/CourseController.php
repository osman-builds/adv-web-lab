<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreCourseRequest;
use App\Http\Requests\Api\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CourseController extends Controller
{
    /**
     * GET /api/v1/courses
     * Returns paginated list of courses (supports ?search= and ?min_credits=).
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $courses = Course::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = $request->query('search');
                $query->where(function ($q) use ($term) {
                    $q->where('code', 'like', "%{$term}%")
                        ->orWhere('name', 'like', "%{$term}%");
                });
            })
            ->when($request->filled('min_credits'), function ($query) use ($request) {
                $query->where('credit_hours', '>=', (int) $request->query('min_credits'));
            })
            ->orderBy('code')
            ->paginate(5);

        return CourseResource::collection($courses);
    }

    /**
     * GET /api/v1/courses-stats
     * Returns summary statistics for courses.
     */
    public function stats(): JsonResponse
    {
        return response()->json([
            'total_courses' => Course::count(),
            'total_credit_hours' => (int) Course::sum('credit_hours'),
            'average_credit_hours' => round((float) Course::avg('credit_hours'), 2),
        ]);
    }

    /**
     * POST /api/v1/courses
     */
    public function store(StoreCourseRequest $request): JsonResponse
    {
        $course = Course::create($request->validated());

        return (new CourseResource($course))
            ->response()
            ->setStatusCode(201); // 201 Created
    }

    /**
     * GET /api/v1/courses/{course}
     */
    public function show(Course $course): CourseResource
    {
        return new CourseResource($course);
    }

    /**
     * PUT/PATCH /api/v1/courses/{course}
     */
    public function update(UpdateCourseRequest $request, Course $course): CourseResource
    {
        $course->update($request->validated());

        return new CourseResource($course);
    }

    /**
     * DELETE /api/v1/courses/{course}
     */
    public function destroy(Course $course): Response
    {
        $course->delete();

        return response()->noContent(); // 204 No Content
    }
}
