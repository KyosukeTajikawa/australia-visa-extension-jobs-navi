<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FarmImages extends Model
{

    protected $fillable = [
        'farm_id',
        'url',
        'path',
    ];

    /**
     * 画像が紐づくファームを取得
     * @return BelongsTo
     */
    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }
}
