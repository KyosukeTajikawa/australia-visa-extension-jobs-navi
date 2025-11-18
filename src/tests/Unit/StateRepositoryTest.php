<?php

namespace Tests\Unit\Repositories;

use App\Models\State;
use App\Repositories\StateRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StateRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private StateRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(StateRepositoryInterface::class);
    }

    /**
     * getAll()メソッドのテスト
     * getAll()が全ての州情報を取得できているか
     */
    public function testGetAll(): void
    {
        $states = State::factory()->sequence(['id' => 1], ['id' => 2])->count(2)->create();

        $result = $this->repository->getAll();

        $this->assertSame($states->modelKeys(), $result->modelKeys());
    }

    /**
     * homeById()メソッドのテスト
     * homeById()が選択された州情報を取得できているか
     */
    public function testHomeById(): void
    {
        $state = State::factory()->sequence(['id' => 5,'name' => 'SA'])->create();

        $stateName = 'SA';

        $result = $this->repository->homeById($stateName);

        $this->assertSame($state->id, $result);
    }
}
