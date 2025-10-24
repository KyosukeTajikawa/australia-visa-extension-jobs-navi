<?php

namespace App\Repositories\Farms;

use App\Models\Crop;
use App\Models\Farm;
use App\Models\FarmImages;
use App\Models\State;
use App\Repositories\Farms\FarmRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FarmRepository implements FarmRepositoryInterface
{
    /**
     * すべてのファーム情報を取得する
     * 登録があればファーム画像(images)も一枚（最も古い）同時に取得する
     * @param array $relation
     * @return Collection<Farm>
     */
    public function getAllFarmsWithImageIfExist(array $relation = []): Collection
    {
        return Farm::with($relation)->get();
    }

    /**
     * 指定したIDのファーム詳細を取得する
     * レビュー情報（reviews）と州情報（state）も同時に取得する。
     * @param int $id
     * @param array $relations
     * @return Farm ファームID,state,あればreviews
     * @throws ModelNotFoundException 例外時404が表示される
     */
    public function getDetailById(int $id, array $relations = []): Farm
    {
        return Farm::with($relations)->findOrFail($id);
    }

    /**
     * すべての州情報を取得する
     * @return Collection<State>
     */
    public function getStates(): Collection
    {
        return State::orderBy('id')->get();
    }

    /**
     * すべての作物情報を取得する
     * @return Collection<Crop>
     */
    public function getCrops(): Collection
    {
        return Crop::orderBy('id')->get();
    }

    /**
     * ファームを登録
     * @param $validatedバリデーションをされた配列
     * @return Farm 登録後のモデルインスタンス
     */
    public function registerFarm($validated): Farm
    {
        return Farm::create($validated);
    }

    /**
     * 画像登録
     * @param array $fileStock 画像が３つまで配列である
     */
    public function registerFarmImage(array $filesStock): void
    {
        FarmImages::insert($filesStock);
    }

    /**
     * 作物登録
     * @param Farm $farm
     * @param array $cropData
     */
    public function registerFarmCrops(Farm $farm, array $cropData): void
    {
        $farm->crops()->sync($cropData);
    }

}
