<?php

namespace Tests\Feature\ReviewController;

use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewCommentStoreTest extends TestCase
{

    use RefreshDatabase;

    /**
     * ReviewCommentStoreの確認
     * リダイレクトができるか
     */
    public function testReviewCommentStore(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $review = Review::factory()->create();

        $request = ['reviewComment' => 'テストコメント'];

        $response = $this->actingAs($user)->post(route('reviewComment.store', ['review' => $review]), $request);

        $response->assertRedirect();
    }
}
