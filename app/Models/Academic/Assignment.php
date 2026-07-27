<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'lesson_id',
        'intruction',
        'lesson_id',
        'rubric_json',
        
    ];

    protected $casts = [
        'rubric_json' => 'array',
    ];

        public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function submissions()
        {
            return $this->hasMany(Submission::class);
        }

}
