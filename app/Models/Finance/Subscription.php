<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'plan_name',
        'status',
        'starts_at',
        'expires_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
