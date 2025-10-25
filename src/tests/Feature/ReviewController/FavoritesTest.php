<?php

namespace Tests\Feature\ReviewController;

use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * favoritesメソッドの確認
     * プロップス（reviewsデータ）が送られているか
     * 各レビューの pivot（中間テーブル）の user_id / review_id が正しいこと
     */
    public function testFavorites(): void
    {
        $user = User::factory()->create();
        $reviews = Review::factory()->count(3)->create();

        $user->reviews()->attach($reviews->modelKeys());

        $response = $this->actingAs($user)->get('/review/favorites');

        $response->assertInertia(
            fn(Assert $page) => $page
            ->component('Review/FavoriteReview')
            ->has('reviews', 3)
            ->where('reviews.0.id', $reviews[0]->id)
            ->where('reviews.0.pivot.review_id', $reviews[0]->id)
            ->where('reviews.0.pivot.user_id', $user->id)
            ->where('reviews.1.pivot.review_id', $reviews[1]->id)
            ->where('reviews.1.pivot.user_id', $user->id)
            ->where('reviews.2.pivot.review_id', $reviews[2]->id)
            ->where('reviews.2.pivot.user_id', $user->id)
        );
    }

    /**
     * favoritesメソッドの確認
     * プロップス（reviewsデータ）が空でもエラーにならないか
     */
    public function testEmptyFavoriteReviewsWhenNoneExist(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/review/favorites')
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Review/FavoriteReview')
                    ->has('reviews', 0)
            );
    }
}
