<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Academic\Lesson;

class UserBookmark extends Model
{
    protected $fillable = [
        'user_id',
        'lesson_id',
        'timestamp',
        'note_text',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(lesson::class);
    }
}
