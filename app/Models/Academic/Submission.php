<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Submission extends Model


{
    protected $fillable = [
        'assignment_id',
        'user_id',
        'file_url',
        'status',
        'score',
        'feedback',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function peerReview()
    {
        return $this->hasMany(PeerReview::class);
    }
}
