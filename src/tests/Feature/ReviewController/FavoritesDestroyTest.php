<?php

namespace Tests\Feature\ReviewController;

use App\Models\Farm;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoritesDestroyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * FavoritesDestroyの確認
     */
    public function testFavoritesDestroy(): void
    {
        $user = User::factory()->create();
        Farm::factory()->create();
        $review = Review::factory()->create();

        $this->actingAs($user)->post(route('favorites.store', ['review' => $review->id]));

        $this->assertDatabaseHas('review_favorites', [
            'review_id' => $review->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->delete(route('review.favorites.destroy', ['review' => $review->id]));

        $response->assertRedirect();


        $this->assertDatabaseMissing('review_favorites', [
            'review_id' => $review->id,
            'user_id' => $user->id,
        ]);
    }
}
