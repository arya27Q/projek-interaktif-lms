<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['user_id', 'lesson_id', 'video_timestamp', 'text'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
