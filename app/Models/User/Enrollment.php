<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Academic\Course;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'progress_percentage',
        'is_completed',
    ];
    protected $casts = [
        'is_completed' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
