<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FarmImages extends Model
{
    protected $fillable = [
        'farm_id',
        'url',
    ];

    /**
     * 画像が紐づくファームを取得
     * return @belongsTo
     */
    public function farm(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
