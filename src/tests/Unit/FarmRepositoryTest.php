<?php

namespace Tests\Unit\Repositories;

use App\Models\Crop;
use App\Models\Farm;
use App\Models\Review;
use App\Models\State;
use App\Models\User;
use App\Repositories\Farms\FarmRepositoryInterface;
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
    public function testGetAllFarmsNoImageAndSearch(): void
    {
        $farms = Farm::Factory()->sequence(['id' => 1], ['id' => 2])->count(2)->create();

        $keyword = '';
        $stateName = '';

        $data = $this->repository->getAllFarmsWithImageAndSearch($keyword, $stateName);

        $result = $data['farms'];

        $this->assertSame($farms->modelKeys(), $result->modelKeys());
        $this->assertCount(2, $result);
    }

    /**
     * getAllFarmsWithImageAndSearch() メソッドのテスト
     * getAllFarmsWithImageAndSearch() が一緒に画像をイーガーロードしているか
     */
    public function testGetAllFarmsWithImageAndSearch(): void
    {
        State::factory()->sequence(['id' => 10, 'name' => 'QLD'])->create();
        $farm = Farm::factory()->sequence(['id' => 5, 'name' => '松田', 'state_id' => 10])->create();

        $farmImage = $farm->images()->create(['farm_id' => 5, 'url' => 'test1.jpeg']);


        $keyword = '松田';
        $stateName = 'QLD';

        $data = $this->repository->getAllFarmsWithImageAndSearch($keyword, $stateName);

        $result =$data['farms'];


        $this->assertCount(1, $result);
        $this->assertSame($farm->id, $result->first()->id);
        $this->assertSame($farm->name, $result->first()->name);
        $this->assertSame($farm->state_id, $result->first()->state_id);
        //getはコレクションを返す。1つ目を選択する
        $this->assertSame($farmImage->url, $result->first()->images->first()->url);
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
     * getCrops()メソッドのテスト
     * getCrops()が全ての作物情報を取得できているか
     */
    public function testGetCrops(): void
    {
        $states = Crop::factory()->sequence(['id' => 1], ['id' => 2])->count(2)->create();

        $result = $this->repository->getCrops();

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
     * registerFarmCrops()メソッドのテスト
     * registerFarmCrops()が作物を中間テーブル(farm_crops)に登録できるか
     */
    public function testRegisterFarmCrops(): void
    {
        $farm = Farm::factory()->create();
        $crops = Crop::factory()->count(3)->create();

        //syncは[1,2,3]のような形を好むためpluckでその形にする。
        $cropIds = $crops->pluck('id')->toArray();

        $this->repository->registerFarmCrops($farm, $cropIds);

        foreach ($crops as $crop) {
            $this->assertDatabaseHas('farm_crops', [
                'farm_id' => $farm->id,
                'crop_id' => $crop->id
            ]);
        }
    }
}
