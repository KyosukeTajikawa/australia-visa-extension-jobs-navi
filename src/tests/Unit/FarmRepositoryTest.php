<?php

namespace Tests\Unit\Repositories;

use App\Models\Farm;
use App\Models\State;
use App\Models\User;
use App\Repositories\FarmRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FarmRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private FarmRepository $repo;

    /**
     * A basic unit test example.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = new FarmRepository();
    }

    public function test_get_all_farms()
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
}
