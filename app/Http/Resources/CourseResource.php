<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'students' => $this->students,
            'teacher' => $this->teacher,
            'chat_id' => $this->chat->id
        ];
    }
}
