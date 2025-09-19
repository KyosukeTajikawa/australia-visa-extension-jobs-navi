<?php

namespace App\Models;

use app\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Review extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'work_position',
        'hourly_wage',
        'pay_type',
        'is_car_required',
        'start_date',
        'end_date',
        'work_rating',
        'salary_rating',
        'hour_rating',
        'relation_rating',
        'overall_rating',
        'comment',
        'user_id',
        'farm_id',
    ];

    /**
     * レビューしたユーザーを取得
     * @return belongsTo
     */
    public function reviewUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

<<<<<<< HEAD
    /**
     * レビューが紐づくファームを取得
     * @return belongsTo
     */
    public function farm(): BelongsTo
=======
    public function farm()
>>>>>>> b86f7ca (controller route 作成)
    {
        return $this->belongsTo(Farm::class);
    }

<<<<<<< HEAD
    /**
     * レビューに紐づくレビューコメントを取得
     * @return hasMany
     */
    public function reviewComments(): HasMany
    {
        return $this->hasMany(Farm::class);
    }

    /**
     * レビューをお気に入りしたユーザーを取得（中間テーブル）
     * @return belongsToMany
     */
    public function favoritedUsers(): BelongsToMany
=======
    public function favoritedBy()
>>>>>>> b86f7ca (controller route 作成)
    {
        return $this->belongsToMany(User::class, 'review_favorites', 'review_id', 'user_id')->withTimestamps();
    }
}
