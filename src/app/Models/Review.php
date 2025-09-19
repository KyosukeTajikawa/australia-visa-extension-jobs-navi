<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\User;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_position',
        'wage',
        'start_date',
        'end_date',
        'work_rating',
        'salary_rating',
        'hour_rating',
        'relation_rating',
        'overall_rating',
        'comment',
        'pay_type',
        'is_car_required',
        'user_id',
        'farm_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'review_favorites', 'review_id', 'user_id')->withTimestamps();
    }
}
