<?php

namespace Tests\Unit\Repositories;

use App\Models\Farm;
use App\Models\Review;
use App\Models\State;
use App\Models\User;
use App\Repositories\FarmRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FarmRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private FarmRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(FarmRepositoryInterface::class);
    }

    /**
     * getAllFarms() メソッドのテスト
     * getAllFarms() が全てのファームを正しく取得できるかを確認する。
     */
    public function testGetAllFarms(): void
    {

        $state = State::factory()->create();
        $user = User::factory()->create();

        Farm::Factory()
            ->for($state, 'state')
            ->for($user, 'user')
            ->count(2)->create();

        $farms = $this->repository->getAllFarms();

        $this->assertCount(2, $farms);
        $this->assertInstanceOf(Farm::class, $farms->first());
    }

    /**
     * getDetailById() メソッドのテスト
     * getAllFarms() の引数がidのみの時、イーガーロードをしていないかを確認する。
     */
    public function testDetailByIdNotComeWithReviewsAndState(): void
    {
        $farm = Farm::factory()->create();
        $found = $this->repository->getDetailById($farm->id);

        $this->assertSame($farm->id, $found->id);
        $this->assertFalse($found->relationLoaded('reviews'));
        $this->assertFalse($found->relationLoaded('state'));
    }

    /**
     * getDetailById() メソッドのテスト
     * getAllFarms() の引数にリレーションがある時、データを取得しているかを確認する。
     */
    public function testDetailByIdComeWithReviewsAndState(): void
    {
        $state = State::factory()->create();

        $farm = Farm::factory()
            ->for($state, 'state')
            ->has(Review::factory()->count(2), 'reviews')
            ->create();

        $found = $this->repository->getDetailById($farm->id, ['state', 'reviews']);

        $this->assertTrue($found->relationLoaded('reviews'));
        $this->assertCount(2, $found->reviews);
        $this->assertTrue($found->relationLoaded('state'));
        $this->assertSame($state->id, $found->state->id);
    }

    /**
     * getDetailById() メソッドのテスト
     * getAllFarms() に引数がない時、findOrFailのModelNotFoundExceptionを返すか確認
     */
    public function testGetDetailByIdThrowsWhenNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->repository->getDetailById(999999);
    }
}
