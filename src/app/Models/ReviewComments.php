<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewComments extends Model
{
    protected $fillable = [
        'review_id',
        'user_id',
        'comment',
    ];

    /**
     * 紐づくユーザーを取得
     * @ return belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 紐づくレビューを取得
     * @ return belongsTo
     */
    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
