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
     * testGetAllFarmsWithImageIfNotExist() メソッドのテスト
     * testGetAllFarmsWithImageIfNotExist() が全てのファームを正しく取得できるか、画像がない時、イーガーロードしていないか確認
     */
    public function testGetAllFarmsWithImageIfNotExist(): void
    {

        $farms = Farm::Factory()->sequence(['id' => 1], ['id' => 2])->count(2)->create();

        $result = $this->repository->getAllFarmsWithImageIfExist();

        $this->assertSame($farms->modelKeys(), $result->modelKeys());
        $this->assertCount(2, $result);

        foreach ($result as $farm) {
            $this->assertFalse($farm->relationLoaded('images'));
        }
    }

    /**
     * testGetAllFarmsWithImageIfExist() メソッドのテスト
     * testGetAllFarmsWithImageIfExist() が一緒に画像をイーガーロードしているか
     */
    public function testGetAllFarmsWithImageIfExist(): void
    {
        $farm = Farm::factory()->create();
        $farm->images()->create(['url' => 'test1.jpeg']);
        $farm->images()->create(['url' => 'test2.jpeg']);

        $result = $this->repository->getAllFarmsWithImageIfExist([
            'images' => function ($query) {
                $query->orderBy('id')->limit(1);
            },
        ]);

        $this->assertSame('test1.jpeg', $result->first()->images->first()->url);
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
     */
    public function testGetDetailByIdThrowsWhenNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->repository->getDetailById(999999);
    }

    /**
     * getStatesU()メソッドのテスト
     * getStates()が全ての州情報を取得できているか
     */
    public function testGetStates(): void
    {
        $states = State::factory()->sequence(['id' => 1], ['id' => 2])->count(2)->create();

        $result = $this->repository->getStates();

        $this->assertSame($states->modelKeys(), $result->modelKeys());
    }

    /**
     * registerFarm()メソッドのテスト
     * registerFarm()で登録できるているか
     */
    public function testRegisterFarm(): void
    {
        $state = State::factory()->create();
        $user = User::factory()->create();

        $validated = [
            'name' => 'A_farm',
            'phone_number' => '0492845949',
            'email' => 'test@gmail.com',
            'street_address' => '2-4-5',
            'suburb' => 'PlainLand',
            'state_id' => $state->id,
            'postcode' => '4000',
            'description' => 'such a good farm',
            'created_user_id' => $user->id,
        ];

        $farm = $this->repository->registerFarm($validated);

        $this->assertDatabaseHas('farms', [
            'id'              => $farm->id,
            'name'            => 'A_farm',
            'state_id'        => $state->id,
            'postcode'        => '4000',
            'created_user_id' => $user->id,
        ]);
    }

    /**
     * registerFarmImage()メソッドのテスト
     * registerFarmImage()が複数の画像を登録できるか
     */
    public function testRegisterFarmImage(): void
    {
        $farm = Farm::factory()->create();

        $filesStock = [
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

        $this->repository->registerFarmImage($filesStock);

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
