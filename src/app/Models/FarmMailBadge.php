<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FarmMailBadge extends Model
{
    protected $table = 'farm_mail_badges';

    protected $fillable = [
        'user_id',
        'farm_id',
        'send_at',
        'failed_at',
        'last_error',
    ];

    protected $cast = [
        'send_at'   => 'datetime',
        'failed_at' => 'datetime,'
    ];

    /**
     * 親テーブル
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 親テーブル
     * @return BelongsTo
     */
    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }
}
