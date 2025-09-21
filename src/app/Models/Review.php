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
        'hourly_wage',
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

    /**
     * 紐づくユーザーを取得
     * @ return belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

<<<<<<< HEAD
    /**
     * 紐づくファームを取得
     * @ return belongsTo
     */
=======
>>>>>>> 75a7975 (controller route 作成)
    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

<<<<<<< HEAD
    /**
     * 紐づくレビューコメントを取得
     * @ return hasMany
     */
    public function reviewComments()
    {
        return $this->hasMany(Farm::class);
    }

    /**
     * 紐づくユーザーを取得
     * @ return belongsToMany
     */
    public function users()
=======
    public function favoritedBy()
>>>>>>> 75a7975 (controller route 作成)
    {
        return $this->belongsToMany(User::class, 'review_favorites', 'review_id', 'user_id')->withTimestamps();
    }
}
