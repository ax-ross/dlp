<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
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
        $students = User::students()->get();
        $teachers = User::teachers()->get();

        $courses = [];
        foreach ($teachers as $teacher) {
            $courses[] = $teacher->teacherCourses()->create(Course::factory()->make()->getAttributes());
        }
        foreach ($courses as $course) {
            $course->students()->attach($students->pluck('id')->toArray());
        }
    }
}
