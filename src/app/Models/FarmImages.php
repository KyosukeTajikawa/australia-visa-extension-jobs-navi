<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FarmImages extends Model
{
    protected $fillable = [
        'farm_id',
        'url',
    ];

    /**
     * 紐づくファームを取得
     * return @belongsTo
     */
    public function farm()
    {
        return $this->belongsTo(User::class);
    }
}
