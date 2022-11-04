<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        return CourseResource::collection(auth()->user()->getCourses());
    }

    public function store(StoreCourseRequest $request)
    {
        $this->authorize('create', Course::class);
        $validated = $request->validated();
        $validated['teacher_id'] = $request->user()->id;
        $course = Course::create($validated);
        return new CourseResource($course);
    }

    public function show(Course $course)
    {
        return new CourseResource($course);
    }
}
