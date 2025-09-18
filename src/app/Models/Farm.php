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
        'street_number',
        'street_name',
        'suburb',
        'postcode',
        'description',
        'state_id',
        'created_user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function crop()
    {
        return $this->belongsToMany(Crop::class, 'farm_crops', 'farm_id', 'crop_id')->withTimestamps();
    }
}
