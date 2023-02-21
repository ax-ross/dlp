<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray(Request $request): array|JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'students' => $this->students,
            'teacher' => $this->teacher,
            'chat_id' => $this->chat->id,
            'lessons' => LessonResource::collection($this->lessons)
        ];
    }
}
