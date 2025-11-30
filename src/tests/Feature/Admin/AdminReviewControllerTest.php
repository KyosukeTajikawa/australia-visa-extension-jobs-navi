<?php

namespace Tests\Feature\Admin;

use App\Models\ApplicationMethod;
use App\Models\Farm;
use App\Models\Review;
use App\Models\ReviewComments;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminReviewControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * editのテスト
     */
    public function testEdit(): void
    {
        $user = User::factory()->create(['is_admin' => 1]);
        $applicationMethod = ApplicationMethod::create(['name' => 'name']);
        $review = Review::factory()->for($applicationMethod, 'applicationMethod')->create();

        $response = $this->actingAs($user)->get("/admin/review/{$review->id}/edit");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('Admin/ReviewEdit')
                ->where('review.comment', $review->comment)
                ->has('applicationMethods', 1)
        );
    }
    /**
     * updateのテスト
     */
    public function testUpdate(): void
    {
        $user = User::factory()->create(['is_admin' => 1]);
        $farm = farm::factory()->for($user, 'user')->create(['name' => 'name']);
        $applicationMethod = ApplicationMethod::create(['name' => 'name']);
        $review = Review::factory()->for($user, 'reviewUser')->for($farm, 'farm')->create();

        $post = [
            'work_position' => 'パッキング',
            'hourly_wage' => '30.7',
            'pay_type' => 1,
            'is_car_required' => 2,
            'start_date' => '3999-12-31',
            'end_date' => null,
            'application_method_id' => $applicationMethod->id,
            'application_method_other' => '',
            'farm_rating' => 5,
            'comment' => 'this farm is great',
            'farm_id' => $farm->id,
            'user_id' => $user->id,
        ];

        $response = $this->actingAs($user)->put(
            route('admin.review.update', ['id' => $review->id]),
            $post
        );

        $response->assertStatus(302);

        $review->refresh();

        $this->assertDatabaseHas('reviews', [
            'work_position' => 'パッキング',
            'hourly_wage' => '30.7',
            'pay_type' => 1,
            'is_car_required' => 2,
            'start_date' => '3999-12-31',
            'end_date' => null,
            'farm_rating' => 5,
            'comment' => 'this farm is great',
        ]);

        $response->assertRedirect(route('user.detail', ['id' => $user->id]));
    }

    /**
     * Destroyの確認
     */
    public function testDestroy(): void
    {
        $user = User::factory()->create(['is_admin' => 1]);
        $farm = farm::factory()->for($user, 'user')->create(['name' => 'name']);
        $review = Review::factory()->for($user, 'reviewUser')->for($farm, 'farm')->create();
        $reviewComment = ReviewComments::create([
            'user_id' => $user->id,
            'review_id' => $review->id,
            'comment' => 'コメント',
        ]);

        $response = $this->actingAs($user)->delete(
            route('admin.review.destroy', ['id' => $review->id])
        );

        $this->assertDatabaseMissing('reviews', [
            'id' => $review->id,
        ]);

        $this->assertDatabaseMissing('review_comments', [
            'id' => $reviewComment->id,
        ]);

        $response->assertRedirect(route('user.detail', ['id' => $user->id]));
    }
}
