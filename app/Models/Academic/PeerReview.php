<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PeerReview extends Model
{
       protected $fillable = [
        'submission_id',
        'reviewer_id',
        'score',
        'feedback_text',
    ];
        // Relasi ke tabel Tugas
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    // Relasi ke Pemilik Tugas (Siswa)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

        public function peerReviews()
    {
        return $this->hasMany(PeerReview::class);
    }

}
