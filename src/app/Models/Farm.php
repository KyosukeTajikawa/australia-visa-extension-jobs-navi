<?php

namespace App\Models;

use App\Events\FarmCreated;
use App\Services\GeocodingService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    /**
     * ファームの州を取得
     * @return BelongsTo
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * ファームに対するレビューを取得
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * ファームで扱っている作物を取得(中間テーブル)
     * @return BelongsToMany
     */
    public function crops(): BelongsToMany
    {
        return $this->belongsToMany(Crop::class, 'farm_crops', 'farm_id', 'crop_id')->withTimestamps();
    }

    /**
     * ファームの画像を取得
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(FarmImages::class);
    }

    /**
     * ファームにもとづく送信結果
     * @return HasMany
     */
    public function farmMailBadges(): HasMany
    {
        return $this->hasMany(FarmMailBadge::class);
    }

    /**
     * 住所を1つに繋げる
     * @return string $parts
     */
    public function fullAddress(): string
    {
        $stateName = $this->state?->name ?? '';

        $parts = array_filter([
            $this->street_address,
            $this->suburb,
            $stateName,
            $this->postcode,
            'Australia',
        ], fn($part) => filled($part));

        return implode(',', $parts);
    }

    /**
     * 新規ファームが登録されたらイベント実行
     * ファーム住所に変更があったら変更した軽度と緯度の登録
     */
    protected static function booted(): void
    {
        static::created(function (Farm $farm) {
            event(new FarmCreated($farm));
        });

        static::saved(function (Farm $farm) {
            $addressFields = ['street_address', 'suburb', 'state_id', 'postcode'];

            $changed = collect($addressFields)->contains(fn($f) => $farm->wasChanged($f));
            if (!$changed) return;

            $address = $farm->fullAddress();
            if (blank($address)) return;

            $geo = app(GeocodingService::class)->geocode($address);
            if (!$geo) return;

            $farm->forceFill([
                'latitude'  => $geo['lat'],
                'longitude' => $geo['lng'],
            ])->saveQuietly();
        });
    }
}
