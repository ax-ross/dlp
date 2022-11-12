<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\AddStudentRequest;
use App\Http\Requests\Course\RemoveStudentRequest;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
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

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $validated = $request->validated();
        $course->update($validated);
        return new CourseResource($course->fresh());
    }

    public function addStudent(AddStudentRequest $request, Course $course)
    {
        $student_id = $request->validated();
        $course->student()->attach($student_id);
        return new CourseResource($course);
    }

    public function removeStudent(RemoveStudentRequest $request, Course $course)
    {
        $student_id = $request->validated();
        $course->students()->detach($student_id);
        return new CourseResource($course);
    }
}
