<?php

namespace Tests\Feature\ReviewController;

use App\Models\Farm;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class FavoritesStoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * favoritesStoreの処理の確認テスト
     * ルート：作成したルートをたどるか
     * pivot：review_favoritesテーブルに保存されるか
     */
    public function testFavoritesStore(): void
    {
        $user = User::factory()->create();
        $farm = Farm::factory()->create();
        $review = Review::factory()->create();

        $response = $this->actingAs($user)->post(route('favorites.store', ['review' => $review->id]));

        $response->assertStatus(302);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('review_favorites', [
            'review_id' => $review->id,
            'user_id' => $user->id,
        ]);

        $response->assertRedirect(route('review.favorites'));
    }
}
