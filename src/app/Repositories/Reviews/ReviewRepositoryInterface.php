<?php

namespace App\Repositories\Reviews;

use App\Models\Farm;
use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

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
     * @param array $relations
     * @return collection
     */
    public function getFavoriteReviews(array $relations = []): collection;

    /**
     * お気に入りレビューを登録
     * @param Review $review
     */
    public function registerFavoriteReview(Review $review): void;

    /**
     * お気に入りレビューを削除
     * @param Review $review
     */
    public function destroyFavoriteReview(Review $review): void;

    /**
     * レビューコメントを登録
     * @param Request $request
     * @param Review $review
     */
    public function registerReviewComment(Request $request, Review $review): void;
}
