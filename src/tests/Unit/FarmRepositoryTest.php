<?php

namespace Tests\Unit\Repositories;

use App\Models\Farm;
use App\Models\Review;
use App\Models\State;
use App\Models\User;
use App\Repositories\FarmRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FarmRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private FarmRepository $repo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = new FarmRepository();
    }

    public function test_get_all_farms(): void
    {

        $state = State::factory()->create();
        $user = User::factory()->create();

        Farm::Factory()
            ->for($state, 'state')
            ->for($user, 'user')
            ->count(2)->create();

        $farms = $this->repo->getAllFarms();

        $this->assertCount(2, $farms);
        $this->assertInstanceOf(Farm::class, $farms->first());
    }

    public function test_detail_by_id_not_come_with_reviews_and_state(): void
    {
        $farm = Farm::factory()->create();
        $found = $this->repo->getDetailById($farm->id);

        $this->assertSame($farm->id, $found->id);
        $this->assertFalse($found->relationLoaded('reviews'));
        $this->assertFalse($found->relationLoaded('state'));
    }

    public function test_detail_by_id_come_with_reviews_and_state(): void
    {
        $state = State::factory()->create();

        $farm = Farm::factory()
            ->for($state, 'state')
            ->has(Review::factory()->count(2), 'reviews')
            ->create();

        $found = $this->repo->getDetailById($farm->id, ['state', 'reviews']);

        $this->assertTrue($found->relationLoaded('reviews'));
        $this->assertCount(2, $found->reviews);
        $this->assertTrue($found->relationLoaded('state'));
        $this->assertSame($state->id, $found->state->id);
    }

    public function test_get_detail_by_id_throws_when_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->repo->getDetailById(999999);
    }
}
