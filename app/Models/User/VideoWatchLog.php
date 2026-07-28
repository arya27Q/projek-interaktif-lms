<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Academic\Lesson;

class VideoWatchLog extends Model
{
    protected $fillable = [
        'user_id',
        'lesson_id',
        'watched_seconds',
        'max_timestamp_reached',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
