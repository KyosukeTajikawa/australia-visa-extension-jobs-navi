<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\Farm;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Crop extends Model
{
    protected $fillable = [
        'name'
    ];

    /**
     * 作物が扱われているファーム取得(中間テーブル)
     * @return belongsToMany
     */
    public function farms(): BelongsToMany
    {
        return $this->belongsToMany(Farm::class, 'farm_crops', 'crop_id', 'farm_id')->withTimestamps();
    }
}
