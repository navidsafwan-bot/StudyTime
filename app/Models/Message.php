<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'course_id',
        'sender_id',
        'receiver_id',
        'message_text',
        'seen_status',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
