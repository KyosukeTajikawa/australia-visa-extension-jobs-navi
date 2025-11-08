<?php

namespace App\Repositories\Reviews;

use App\Models\Farm;
use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;

interface ReviewRepositoryInterface
{
    /**
     * レビュー登録ページ
     * @param int $id
     * @return Farm
     */
    public function getCreateById(int $id): Farm;

    /**
     * レビューを登録
     * @param $validatedバリデーションをされた配列
     * @return Review 登録後のモデルインスタンス
     */
    public function registerReview(array $validated): Review;

    /**
     * お気に入りレビューを取得
     * @return collection
     */
    public function getFavoriteReviews(): collection;

    /**
     * お気に入りレビューを登録
     * @return Review
     */
    public function registerFavoriteReview(Review $review): void;
}
