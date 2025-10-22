<?php

namespace App\Models;

use App\Models\Farm;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Crop extends Model
{

    use HasFactory;

    protected $fillable = [
        'name'
    ];

    /**
     * 紐づくファームを取得
     * @return BelongsToMany
     */
    public function farms(): BelongsToMany
    {
        return $this->belongsToMany(Farm::class, 'farm_crops', 'crop_id', 'farm_id')->withTimestamps();
    }
}
