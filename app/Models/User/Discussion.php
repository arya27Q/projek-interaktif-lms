<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Academic\Course;
use App\Models\Academic\Lesson;

class Discussion extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'lesson_id',
        'parent_id',
        'timestamp_context',
        'message',
        'upvotes_count',
    ];

    public function user()
    {
        return $this->belongsTO(User::class);
    }

    public function course()
    {
        return $this->belongsTO(Course::class);
    }

    public function lesson()
    {
        return $this->belongsTO(Lesson::class);
    }
   
        
    public function replies()
    {
        
        return $this->hasMany(Discussion::class, 'parent_id');
    }

   
    public function parent()
    {
     
        return $this->belongsTo(Discussion::class, 'parent_id');
    }

}
