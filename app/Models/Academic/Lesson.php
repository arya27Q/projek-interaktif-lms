<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'module_id',
        'title',
        'type',
        'media_url',
        'order_index',
    ];

    public function module()
     {
        return $this->belongsTO(Module::class);
     }

    public function videoInteractions()
    {
        return $this->hasMany(VideoInteraction::class);
    }
    
    public function assignment()
    {
        return $this->hasOne(Assignment::class);
    }
    
}
