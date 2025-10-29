<?php

namespace Tests\Unit;

use App\Models\Farm;
use App\Models\Review;
use App\Models\User;
use App\Repositories\Reviews\ReviewRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ReviewRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(ReviewRepositoryInterface::class);
    }

    /**
     * getCreateById()のテスト
     * getCreateById() がファーム（idとnameのみ）を正しく取得している
     */
    public function testGetCreateById(): void
    {
        $farm = Farm::factory()->create();

        $result = $this->repository->getCreateById($farm->id);

        $this->assertSame($farm->id, $result->id);
        $this->assertSame($farm->name, $result->name);
        $this->assertNull($result->postcode);
    }

    /**
     * registerReview()のテスト
     * registerReview() がデータをテーブルに登録できているか
     */
    public function testRegisterReview(): void
    {

        $farm = Farm::factory()->create();

        $review = [
            'work_position' => 'パッキング',
            'hourly_wage' => '30.7',
            'pay_type' => 1,
            'is_car_required' => 2,
            'start_date' => '3999-12-31',
            'end_date' => null,
            'work_rating' => 1,
            'salary_rating' => 2,
            'hour_rating' => 3,
            'relation_rating' => 4,
            'overall_rating' => 5,
            'comment' => 'this farm is great',
            'user_id' => $farm->created_user_id,
            'farm_id' => $farm->id,
        ];

        $this->repository->registerReview($review);

        $this->assertDatabaseHas('reviews', $review);
    }

    /**
     * getFavoriteReviews()のテスト
     * getFavoriteReviews() がデータを取得できている
     */
    public function testGetFavoriteReviews(): void
    {
        $user = User::factory()->create();

            $reviews = Review::factory()->sequence(['id' => 10], ['id' => 15], ['id' => 20])->count(3)->create();

            $user->reviews()->attach($reviews->modelKeys());

            $result = $this->actingAs($user)->repository->getFavoriteReviews();

        $this->assertSame($reviews->modelKeys(), $result->modelKeys());
    }

    /**
     * registerFavoriteReview()のテスト
     * registerFavoriteReview() がpivot(review_favorites)にデータを登録できている
     */
    public function testRegisterFavoriteReview(): void
    {
        $user = User::factory()->create();
        $reviews = Review::factory()->sequence(['id' => 10], ['id' => 15], ['id' => 20])->count(3)->create();

        $this->actingAs($user);

        foreach ($reviews as $review) {
            $this->repository->registerFavoriteReview($review);
        };

        foreach ($reviews as $review) {
            $this->assertDatabaseHas('review_favorites',[
                'user_id' => $user->id,
                'review_id' => $review->id,
            ]);
        }
    }
}
