<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Academic\Lesson;

class QuizAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'lesson_id',
        'score',
        'passed',
    ];

    protected $casts = [
        'passed' => 'boolean',
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
