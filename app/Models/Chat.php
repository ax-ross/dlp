<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'course_id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_chat');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
