<?php

namespace Tests\Feature;

use App\Models\Chat;
use App\Models\Course;
use App\Models\User;
use Database\Seeders\CourseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $response->assertJson(fn(AssertableJson $json) => $json->has('data', Course::where('teacher_id', $teacher->id)->count())->has('data.0', fn(AssertableJson $json) => $json->whereAllType(['id' => 'integer', 'title' => 'string', 'updated_at' => 'string', 'created_at' => 'string', 'students' => 'array', 'teacher' => 'array', 'chat_id' => 'integer', 'lessons' => 'array'])
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
        $response->assertJson(fn(AssertableJson $json) => $json->has('data', $student->studentCourses()->count())->has('data.0', fn(AssertableJson $json) => $json->whereAllType(['id' => 'integer', 'title' => 'string', 'updated_at' => 'string', 'created_at' => 'string', 'students' => 'array', 'teacher' => 'array', 'chat_id' => 'integer', 'lessons' => 'array'])
        )
        );
    }

    public function test_store_course_for_teacher()
    {
        $teacher = User::factory()->teacher()->create();
        $course = Course::factory()->make(['teacher_id' => $teacher->id]);
        $response = $this->actingAs($teacher)->postJson('/api/courses', $course->getAttributes());
        $response->assertStatus(201);
        $response->assertJson(fn(AssertableJson $json) => $json->has('data', fn(AssertableJson $json) => $json->whereAllType(['id' => 'integer', 'title' => 'string', 'updated_at' => 'string', 'created_at' => 'string', 'students' => 'array', 'teacher' => 'array', 'chat_id' => 'integer', 'lessons' => 'array'])->where('title', $course->title)->where('teacher.id', $teacher->id)
        )
        );

    }

    public function test_store_course_for_student()
    {
        $student = User::factory()->student()->create();
        $course = Course::factory()->make();
        $response = $this->actingAs($student)->postJson('/api/courses', $course->getAttributes());
        $response->assertStatus(403);
    }

    public function test_show_course()
    {
        $course = Course::factory()->has(Chat::factory())->create();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson("/api/courses/{$course->id}");
        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) => $json->has('data', fn(AssertableJson $json) => $json->whereAllType(['id' => 'integer', 'title' => 'string', 'updated_at' => 'string', 'created_at' => 'string', 'students' => 'array', 'teacher' => 'array', 'chat_id' => 'integer', 'lessons' => 'array'])
        )
        );
    }

    public function test_update_course_for_teacher()
    {
        $courseAuthor = User::factory()->teacher()->create();
        $course = Course::factory()->has(Chat::factory())->create(['teacher_id' => $courseAuthor->id]);
        $response = $this->actingAs($courseAuthor)->postJson("/api/courses/{$course->id}", ['title' => 'test title']);
        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) => $json->has('data', fn(AssertableJson $json) => $json->whereAllType(['id' => 'integer', 'title' => 'string', 'updated_at' => 'string', 'created_at' => 'string', 'students' => 'array', 'teacher' => 'array', 'chat_id' => 'integer', 'lessons' => 'array'])->where('title', 'test title')
        )
        );

        $anotherTeacher = User::factory()->teacher()->create();
        $response = $this->actingAs($anotherTeacher)->postJson("/api/courses/{$course->id}", ['title' => 'test title2']);
        $response->assertStatus(403);
    }

    public function test_update_course_for_student()
    {
        $course = Course::factory()->has(Chat::factory())->create();
        $user = User::factory()->student()->create();
        $response = $this->actingAs($user)->postJson("/api/courses/{$course->id}", ['title' => 'test title']);
        $response->assertStatus(403);
    }
}
