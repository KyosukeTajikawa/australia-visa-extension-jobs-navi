<?php

namespace App\Repositories;

use App\Models\Farm;
use App\Repositories\FarmRepositoryInterface;
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
        return Farm::with($relation)->orderBy('id')->get();
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
     * ファームを登録
     * @param $validatedバリデーションをされた配列
     * @return Farm 登録後のモデルインスタンス
     */
    public function registerFarm($validated): Farm
    {
        return Farm::create($validated);
    }
}
