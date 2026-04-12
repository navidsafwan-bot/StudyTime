<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    protected $fillable = ['course_id', 'title', 'file_path'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
