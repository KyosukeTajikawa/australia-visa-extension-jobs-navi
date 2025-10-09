<?php

namespace Tests\Unit\Repositories;

use App\Models\Farm;
use App\Models\Review;
use App\Models\State;
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

        $farms = Farm::Factory()->count(3)->create();

        $result = $this->repository->getAllFarms();

        $this->assertCount(3, $result);
        $this->assertSame($farms[0]->id, $result[0]->id);
        $this->assertSame($farms[1]->id, $result[1]->id);
        $this->assertSame($farms[2]->id, $result[2]->id);
        $this->assertInstanceOf(Farm::class, $result->first());
    }

    /**
     * getDetailById() メソッドのテスト
     * getAllFarms() の引数がidのみの時、イーガーロードをしていないかを確認する。
     */
    public function testDetailByIdNotComeWithReviewsAndState(): void
    {
        $farm = Farm::factory()->create();
        $result = $this->repository->getDetailById($farm->id);

        $this->assertSame($farm->id, $result->id);
        $this->assertFalse($result->relationLoaded('reviews'));
        $this->assertFalse($result->relationLoaded('state'));
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

        $result = $this->repository->getDetailById($farm->id, ['state', 'reviews']);

        $this->assertTrue($result->relationLoaded('reviews'));
        $this->assertCount(2, $result->reviews);
        $this->assertTrue($result->relationLoaded('state'));
        $this->assertSame($state->id, $result->state->id);
    }

    /**
     * getDetailById() メソッドのテスト
     * getAllFarms() に存在しない引数が渡された時、findOrFailのModelNotFoundExceptionを返すか確認
     * getAllFarms() に引数が渡されなかった時、findOrFailのModelNotFoundExceptionを返すか確認
     */
    public function testGetDetailByIdThrowsWhenNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->repository->getDetailById(999999);

        $this->expectException(ModelNotFoundException::class);
        $this->repository->getDetailById();
    }
}
