<?php

namespace Tests\Unit\Repositories;

use App\Models\Farm;
use App\Repositories\FarmImageRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FarmImageRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private FarmImageRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(FarmImageRepositoryInterface::class);
    }

    /**
     * bulkInsert()メソッドのテスト
     * bulkInsert()が複数の画像を登録できるか
     */
    public function testBulkInsert(): void
    {
        $farm = Farm::factory()->create();

        $insertValues = [
            [
                'url'        => 'test1.Jpeg',
                'farm_id'    => $farm->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'url'        => 'test2.Jpeg',
                'farm_id'    => $farm->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        $this->repository->bulkInsert($insertValues);

        $this->assertDatabaseHas(
            'farm_images',
            [
                'url'        => 'test1.Jpeg',
                'farm_id'    => $farm->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        $this->assertDatabaseHas(
            'farm_images',
            [
                'url'        => 'test2.Jpeg',
                'farm_id'    => $farm->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
