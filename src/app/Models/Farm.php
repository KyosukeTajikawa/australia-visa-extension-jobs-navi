<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Crop;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Farm extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'street_address',
        'suburb',
        'state_id',
        'postcode',
        'description',
        'created_user_id',
    ];

    /**
     * 紐づくユーザーを取得
     * @return belongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 紐づく州を取得
     * @return belongsTo
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
    public function review()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * 紐づくレビューを取得
     * @return hamMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * 紐づく作物を取得（中間テーブル）
     * @return belongsToMany
     */
    public function crops(): BelongsToMany
    {
        return $this->belongsToMany(Crop::class, 'farm_crops', 'farm_id', 'crop_id')->withTimestamps();
    }
}
