<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Academic\Course;

class Transaction extends Model
{
    protected $fillable =[
        'user_id',
        'course_id',
        'midtrans_order_id',
        'transaction_id',
        'amount',
        'payment_method',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
