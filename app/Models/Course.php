<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'teacher_id'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_student', 'course_id', 'user_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function chat()
    {
        return $this->hasOne(Chat::class);
    }
}
