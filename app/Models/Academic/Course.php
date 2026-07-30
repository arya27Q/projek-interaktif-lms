<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Course extends Model
{
    protected $fillable = [
        'instructor_id',
        'title',
        'category',
        'level',
        'thumbnail_url',
        'price',
        'average_rating',
        'status',
        'slug',
        'description'
    ];

    public function instructor()
    {
        return $this->belongsTo(User::class,'instructor_id');
    }
    
    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('order_index');
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Module::class);
    }

    public function scopeCategory($query, $category)
    {
        if ($category && $category !== 'Semua Kategori') {
            return $query->where('category', $category);
        }
        return $query;
    }
}
