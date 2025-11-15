<?php

namespace App\Repositories\Reviews;

use App\Models\Farm;
use App\Models\Review;
use App\Models\ReviewComments;
use App\Repositories\Reviews\ReviewRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

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

    /**
     * お気に入りレビューを取得
     * @param array $relation
     * @return collection
     */
    public function getFavoriteReviews(array $relations = []): collection
    {
        return auth()->user()->reviews()->with(array_merge($relations, [
            'reviewUser:id,nickname',
            'reviewUser.image:id,user_id,url',
        ]))->orderBy('review_favorites.review_id')->get();
    }

    /**
     * お気に入りレビューを登録
     * @param Review $review
     */
    public function registerFavoriteReview(Review $review): void
    {
        $review->favoritedUsers()->syncWithoutDetaching([auth()->id()]);
    }

    /**
     * お気に入りレビューを削除
     * @param Review $review
     */
    public function destroyFavoriteReview(Review $review): void
    {
        $review->favoritedUsers()->detach([auth()->id()]);
    }

    /**
     * レビューコメントを登録
     * @param Request $request
     * @param Review $review
     */
    public function registerReviewComment(Request $request, Review $review): void
    {
        ReviewComments::create(
            [
                'review_id' => $review->id,
                'user_id' => auth()->id(),
                'comment' => $request->reviewComment,
            ]
        );
    }
}
