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
     * @return Collection<Farm>
     */
    public function getAllFarms(): Collection
    {
        return Farm::orderBy('id', 'asc')->get();
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
}
