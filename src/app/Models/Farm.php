<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Crop;

class Farm extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'street_address',
        'suburb',
        'postcode',
        'phone_number',
        'email',
        'description',
        'state_id',
        'created_user_id',
    ];

    /**
     * 紐づくユーザーを取得
     * @return belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 紐づく州を取得
     * @return belongsTo
     */
    public function state()
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
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * 紐づく作物を取得
     * @return belongsToMany
     */
    public function crops()
    {
        return $this->belongsToMany(Crop::class, 'farm_crops', 'farm_id', 'crop_id')->withTimestamps();
    }
}
