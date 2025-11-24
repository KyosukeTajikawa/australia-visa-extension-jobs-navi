<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Review;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nickname',
        'email',
        'password',
        'gender',
        'birthday',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'deleted_at' => 'datetime',
    ];

    /**
     * ユーザーが作成したファームを取得
     * @return HasMany
     */
    public function farms(): HasMany
    {
        return $this->hasMany(Farm::class, 'created_user_id');
    }

    /**
     * ユーザーがお気に入りしたレビューを取得（中間テーブル）
     * @return BelongsToMany
     */
    public function reviews(): BelongsToMany
    {
        return $this->belongsToMany(Review::class, 'review_favorites', 'user_id', 'review_id')->withTimestamps();
    }

    /**
     * ファームの画像を取得
     * @return HasOne
     */
    public function image(): HasOne
    {
        return $this->hasOne(UserImage::class);
    }
}
