<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'order_index',
        'is_remedial',
    ];

    protected $casts = [
        'is_remedial' => 'boolean',
    ];

    public function course()
     {
        return $this->belongsTO(Course::class);
     }
    public function lessons()
     {
        return $this->hasMany(Lesson::class);
     }
    
}
