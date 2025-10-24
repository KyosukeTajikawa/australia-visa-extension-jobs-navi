<?php

namespace App\Repositories\Reviews;

use App\Models\Farm;
use App\Models\Review;
use App\Repositories\Reviews\ReviewRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ReviewRepository implements ReviewRepositoryInterface
{
    /**
     * レビュー登録ページ
     * @param int $id
     * @return Farm
     */
    public function getCreateById(int $id): Farm
    {
        return Farm::select('id', 'name')->findOrFail($id);
    }

    /**
     * レビューを登録
     * @param $validatedバリデーションをされた配列
     * @return Review 登録後のモデルインスタンス
     */
    public function registerReview(array $validated): Review
    {
        return Review::create($validated);
    }
}
