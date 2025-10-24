<?php

namespace Tests\Unit;

use App\Models\Farm;
use App\Models\Review;
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
}
