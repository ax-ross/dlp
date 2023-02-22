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
    public function index(Course $course): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return LessonResource::collection($course->lessons);
    }

    public function store(StoreLessonRequest $request, Course $course): LessonResource
    {
        $validated = $request->validated();
        $lesson = $course->lessons()->create($validated);
        if (isset($validated['attachments'])) {
            foreach ($validated['attachments'] as $attachment) {
                LessonAttachment::create(['path' => $attachment->store('/attachments'), 'lesson_id' => $lesson->id]);
            }
        }

        foreach ($request->images as $image) {
            $lesson->images()->save($image);
        }

        return new LessonResource($lesson);
    }

    public function show(Course $course, Lesson $lesson): LessonResource
    {
        return new LessonResource($lesson);
    }
}
