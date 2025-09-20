<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\Farm;

class Crop extends Model
{
    protected $fillable = [
        'name'
    ];

    /**
     * 紐づくファームを取得
     * @ return belongsToMany
     */
    public function farms()
    {
        return $this->belongsToMany(Farm::class, 'farm_crops', 'crop_id', 'farm_id')->withTimestamps();
    }
}
