<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FarmImages extends Model
{
    protected $fillable = [
        'farm_id',
        'url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
