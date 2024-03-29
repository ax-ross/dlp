<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\AddStudentRequest;
use App\Http\Requests\Course\RemoveStudentRequest;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Chat;
use App\Models\Course;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class CourseController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return CourseResource::collection(auth()->user()->getCourses());
    }

    public function store(StoreCourseRequest $request): CourseResource
    {
        $this->authorize('create', Course::class);
        $validated = $request->validated();
        $user = $request->user();
        $course = $user->teacherCourses()->create($validated);
        $chat = $course->chat()->create($validated);
        $chat->users()->attach($request->user()->id);


        return new CourseResource($course);
    }

    public function show(Course $course): CourseResource
    {
        return new CourseResource($course);
    }

    public function update(UpdateCourseRequest $request, Course $course): CourseResource
    {
        $this->authorize('update', $course);
        $validated = $request->validated();
        $course->update($validated);
        return new CourseResource($course->fresh());
    }

    public function addStudent(AddStudentRequest $request, Course $course): CourseResource
    {
        $this->authorize('update', $course);
        $student_email = $request->validated();
        $student = User::where('email', $student_email)->first();
        if ($course->students->contains($student->id)) {
            throw ValidationException::withMessages(['email' => 'пользователь с данным email уже добавлен']);
        }
        $course->students()->attach($student->id);
        $course->chat->users()->attach($student->id);
        return new CourseResource($course);
    }

    public function removeStudent(RemoveStudentRequest $request, Course $course): CourseResource
    {
        $this->authorize('update', $course);
        $student_email = $request->validated();
        $student = User::where('email', $student_email)->first();
        $course->students()->detach($student->id);
        $course->chat->users()->detach($student->id);
        return new CourseResource($course);
    }

}
