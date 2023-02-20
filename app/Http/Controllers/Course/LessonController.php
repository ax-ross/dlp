<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Resources\LessonResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonAttachment;

class LessonController extends Controller
{
    public function index(Course $course)
    {
        return $course->lessons;
    }

    public function store(StoreLessonRequest $request, Course $course)
    {
        $validated = $request->validated();
        $lesson = $course->lessons()->create($validated);
        if (isset($validated['attachments'])) {
            foreach ($validated['attachments'] as $attachment) {
                LessonAttachment::create(['path' => $attachment->store('/attachments'), 'lesson_id' => $lesson->id]);
            }
        }
        return new LessonResource($lesson);
    }

    public function show(Course $course, Lesson $lesson)
    {
        return new LessonResource($lesson);
    }
}
