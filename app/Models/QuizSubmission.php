<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Quiz;
use App\Models\User;

class QuizSubmission extends Model
{
    protected $fillable = ['quiz_id', 'user_id', 'answers', 'score'];

    protected $casts = [
        'answers' => 'array',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
