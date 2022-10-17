<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['inviter_id'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}
