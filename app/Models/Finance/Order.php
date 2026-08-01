<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'status',
        'total_price',
        'snap_token',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function course()
    {
        return $this->belongsTo(\App\Models\Academic\Course::class);
    }
}
