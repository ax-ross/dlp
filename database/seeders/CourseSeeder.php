<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Course;
use App\Models\User;
use Database\Factories\ChatFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $teachers = User::factory()->count(5)->teacher()->create();
        $studentIds = User::factory()->count(20)->student()->create()->pluck('id')->toArray();

        foreach ($teachers as $teacher) {
            $courses = $teacher->teacherCourses()->saveMany(Course::factory()->count(10)->has(Chat::factory())->recycle($teachers)->create());
            foreach ($courses as $course) {
                $course->students()->attach($studentIds);
            }
        }
    }
}
