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
                'path' => 'farm/10/test1.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'url'        => 'test2.Jpeg',
                'farm_id'    => $farm->id,
                'path' => 'farm/20/test2.jpeg',
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
                'path' => 'farm/10/test1.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $this->assertDatabaseHas(
            'farm_images',
            [
                'url'        => 'test2.Jpeg',
                'farm_id'    => $farm->id,
                'path' => 'farm/20/test2.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * getByFarmId()メソッドのテスト
     * getByFarmId()がファームidに紐ずく画像を取得できるか
     */
    public function testGetByFarmId(): void
    {
        $farm = Farm::factory()->sequence(['id' => 10], ['id' => 20])->count(2)->create();

        $farmId = $farm->first()->id;

        $farmImages = [
            [
                'url'        => 'test1.Jpeg',
                'farm_id'    => $farmId,
                'path' => 'farm/10/test1.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'url'        => 'test2.Jpeg',
                'farm_id'    => 20,
                'path' => 'farm/20/test2.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        $this->repository->bulkInsert($farmImages);

        $result = $this->repository->getByFarmId($farmId);

        $resultArray = $result->toArray();

        $this->assertSame($farmImages[0]['url'], $resultArray[0]['url']);
        $this->assertSame($farmImages[0]['farm_id'], $resultArray[0]['farm_id']);
        $this->assertSame($farmImages[0]['path'], $resultArray[0]['path']);
    }

    /**
     * deleteByFarmId()メソッドのテスト
     * deleteByFarmId()がファームidに紐ずく画像を削除できるか
     */
    public function testDeleteByFarmId(): void
    {
        $farm = Farm::factory()->sequence(['id' => 10], ['id' => 20])->count(2)->create();

        $farmId = $farm->first()->id;

        $farmImages = [
            [
                'url'        => 'test1.Jpeg',
                'farm_id'    => $farmId,
                'path' => 'farm/10/test1.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'url'        => 'test2.Jpeg',
                'farm_id'    => 20,
                'path' => 'farm/20/test2.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        $this->repository->bulkInsert($farmImages);

        $this->repository->deleteByFarmId($farmId);

        $this->assertDatabaseMissing(
            'farm_images',
            [
                'url'        => 'test1.Jpeg',
                'farm_id'    => $farmId,
                'path' => 'farm/10/test1.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        $this->assertDatabaseHas(
            'farm_images',
            [
                'url'        => 'test2.Jpeg',
                'farm_id'    => 20,
                'path' => 'farm/20/test2.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
