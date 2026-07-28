<?php

namespace App\Models\Gamification;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class GamificationStat extends Model
{
    protected $fillable = [
        'user_id',
        'current_streak',
        'total_exp',
        'rank_tier',
        'last_login_date',
    ];

    protected $casts = [
        'last_login_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
