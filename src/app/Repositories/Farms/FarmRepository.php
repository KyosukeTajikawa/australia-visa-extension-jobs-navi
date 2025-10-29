<?php

namespace App\Repositories\Farms;

use App\Models\Crop;
use App\Models\Farm;
use App\Repositories\Farms\FarmRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FarmRepository implements FarmRepositoryInterface
{
    /**
     * すべてのファーム情報を取得する
     * 検索キーワードによるデータ取得
     * @param array $keyword
     * @param array $stateName
     * @return Collection<Farm>
     */
    public function getAllFarmsWithImageAndSearch(?string $keyword, ?string $stateName): array
    {
        $farmQuery = Farm::with(['images' => function ($q) {
            $q->orderBy('id')->limit(1);
        }, 'state']);

        if (!empty($keyword)) {
            $farmQuery->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%");
            });
        }

        if (!empty($stateName)) {
            $stateId = State::where('name', $stateName)->value('id');
        }
        if (!empty($stateId)) {
            $farmQuery->where('state_id', $stateId);
        }

        $farms = $farmQuery->orderBy('id')->get();

        return [
            'farms' => $farms,
            'keyword' => $keyword,
            'stateName' => $stateName
        ];
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
     * 作物登録
     * @param Farm $farm
     * @param array $cropData
     */
    public function registerFarmCrops(Farm $farm, array $cropData): void
    {
        $farm->crops()->sync($cropData);
    }
}
