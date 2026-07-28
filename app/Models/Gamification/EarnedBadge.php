<?php

namespace App\Models\Gamification;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class EarnedBadge extends Model
{
    protected $fillable = [
        'user_id',
        'badge_name',
        'earned_at',
    ];

    protected $casts = [
        'earned_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
