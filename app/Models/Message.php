<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'chat_id', 'sender_id'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function chat()
    {
        return $this->hasOne(Chat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->diffForHumans();
    }
}
