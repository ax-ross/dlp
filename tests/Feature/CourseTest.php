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

    public function test_index_course()
    {
        $this->seed([
            CourseSeeder::class
        ]);

        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user)->getJson('/api/courses');
        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) => $json->has('data', $user->getCourses()->count())->has('data.0', fn(AssertableJson $json) => $json->whereAllType(['id' => 'integer', 'title' => 'string', 'updated_at' => 'string', 'created_at' => 'string', 'students' => 'array', 'teacher' => 'array', 'chat_id' => 'integer', 'lessons' => 'array'])
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

    public function test_update_course()
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

    public function test_add_student_to_course()
    {
        $courseAuthor = User::factory()->teacher()->create();
        $student = User::factory()->student()->create();
        $course = Course::factory()->has(Chat::factory())->create(['teacher_id' => $courseAuthor->id]);
        $response = $this->actingAs($courseAuthor)->postJson("/api/courses/{$course->id}/add-student", ['email' => $student->email]);
        $response->assertStatus(200);
        $this->assertTrue($course->students->contains($student));


        $anotherTeacher = User::factory()->teacher()->create();
        $anotherStudent = User::factory()->student()->create();
        $response = $this->actingAs($anotherTeacher)->postJson("/api/courses/{$course->id}/add-student", ['email' => $anotherStudent->email]);
        $response->assertStatus(403);
        $this->assertFalse($course->students->contains($anotherStudent));
    }

    public function test_remove_student_from_course()
    {
        $courseAuthor = User::factory()->teacher()->create();
        $student = User::factory()->student()->create();
        $course = Course::factory()->has(Chat::factory())->create(['teacher_id' => $courseAuthor->id]);
        $course->students()->attach($student);
        $response = $this->actingAs($courseAuthor)->postJson("/api/courses/{$course->id}/remove-student", ['email' => $student->email]);
        $response->assertStatus(200);
        $this->assertFalse($course->students->contains($student));

        $anotherTeacher = User::factory()->teacher()->create();
        $course->students()->attach($student);
        $course->load('students');
        $response = $this->actingAs($anotherTeacher)->postJson("/api/courses/{$course->id}/remove-student", ['email' => $student->email]);
        $response->assertStatus(403);
        $this->assertTrue($course->students->contains($student));
    }

}
