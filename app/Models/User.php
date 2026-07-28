<?php

namespace App\Models;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Academic\Course;
use App\Models\Academic\Submission;
use App\Models\Finance\Transaction;
use App\Models\Finance\Subscription;
use App\Models\Gamification\EarnedBadge;
use App\Models\Gamification\GamificationStat;
use App\Models\User\Discussion;
use App\Models\User\Enrollment;
use App\Models\User\QuizAttempt;
use App\Models\User\UserBookmark;
use App\Models\User\VideoWatchLog;
use App\Models\Academic\PeerReview;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function courses()
    {
        return $this->hasMany(Course::class,'instructor_id');
    }    
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    public function earnedBadges()
    {
        return $this->hasMany(EarnedBadge::class);
    }
    public function gamificationstat()
    {
        return $this->hasOne(GamificationStat::class);
    }
    public function discussions() 
    {
        return $this->hasMany(Discussion::class);
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
    public function bookmarks()
    {
        return $this->hasMany(UserBookmark::class);
    }
    public function videoWatchLogs()
    {
        return $this->hasMany(VideoWatchLog::class);
    }   
     public function peerReviews()
    {
        return $this->hasMany(PeerReview::class, 'reviewer_id');
    }

}
