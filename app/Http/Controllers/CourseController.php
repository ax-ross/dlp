<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\AddStudentRequest;
use App\Http\Requests\Course\RemoveStudentRequest;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Chat;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\JsonResponse;

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

        $chat = Chat::create(['title' => $validated['title'], 'course_id' => $course->id]);
        $chat->users()->attach($request->user()->id);


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
        $student_email = $request->validated();
        $student = User::where('email', $student_email)->first();
        $course->students()->attach($student->id);
        $course->chat->users()->attach($student->id);
        return new CourseResource($course);
    }

    public function removeStudent(RemoveStudentRequest $request, Course $course)
    {
        $student_email = $request->validated();
        $student = User::where('email', $student_email)->first();
        $course->students()->detach($student->id);
        return new CourseResource($course);
    }

    public function getChat(Course $course)
    {
        $chat = $course->chat()->with(['users', 'messages.user' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }])->get();
        return $chat;
    }
}
