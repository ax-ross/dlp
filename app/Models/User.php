<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public static string $defaultAvatar = 'http://127.0.0.1/images/default-avatar.svg';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    public function scopeTeachers($query)
    {
        return $query->where('role', 'teacher');
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'users_chats');
    }

    public function teacherCourses()
    {
        if ($this->isStudent()) {
            return null;
        }
        return $this->hasMany(Course::class, 'teacher_id', 'id');
    }

    public function studentCourses()
    {
        if ($this->isTeacher()) {
            return null;
        }
        return $this->belongsToMany(Course::class, 'course_student', 'user_id', 'course_id');
    }

    public function getCourses()
    {
        if ($this->isTeacher()) {
            return $this->teacherCourses;
        } else {
            return $this->studentCourses;
        }
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => url('/storage', $value)
        );
    }
}
