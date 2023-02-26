<?php

namespace Tests\Feature;

use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\User;
use Database\Seeders\CourseSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_course_for_teacher()
    {
        $this->seed([
            CourseSeeder::class
        ]);

        $teacher = User::teachers()->inRandomOrder()->first();
        $response = $this->actingAs($teacher)->getJson('/api/courses');
        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) =>
            $json->has('data', Course::where('teacher_id', $teacher->id)->count())->has('data.0', fn (AssertableJson $json) =>
            $json->whereAllType(['id' => 'integer', 'title' => 'string', 'updated_at' => 'string', 'created_at' => 'string', 'students' => 'array', 'teacher' => 'array', 'chat_id' => 'integer', 'lessons' => 'array'])
            )
        );
    }

    public function test_index_course_for_student()
    {
        $this->seed([
            CourseSeeder::class
        ]);

        $student = User::students()->inRandomOrder()->first();
        $response = $this->actingAs($student)->getJson('/api/courses');
        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) =>
        $json->has('data', $student->studentCourses()->count())->has('data.0', fn (AssertableJson $json) =>
        $json->whereAllType(['id' => 'integer', 'title' => 'string', 'updated_at' => 'string', 'created_at' => 'string', 'students' => 'array', 'teacher' => 'array', 'chat_id' => 'integer', 'lessons' => 'array'])
        )
        );
    }
}
