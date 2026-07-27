<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class VideoInteraction extends Model
{
    protected $fillable = [
        'lesson_id',
        'timestamp_trigger',
        'quiz_payload',
    ];

    protected $casts = [
        'quiz_payload' => 'array',
    ];
    
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
