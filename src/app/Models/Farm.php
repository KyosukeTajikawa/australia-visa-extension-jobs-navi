<?php

namespace App\Models;

use app\Models\Crop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
     * ファーム情報を登録したユーザーを取得
     * @return belongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ファームの住所（州）を取得
     * @return belongsTo
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * ファームに対するレビューを取得
     * @return hamMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * ファームで扱っている作物を取得(中間テーブル)
     * @return belongsToMany
     */
    public function crops(): BelongsToMany
    {
        return $this->belongsToMany(Crop::class, 'farm_crops', 'farm_id', 'crop_id')->withTimestamps();
    }
}
