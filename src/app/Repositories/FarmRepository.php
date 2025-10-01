<?php

namespace App\Repositories;

use App\Models\Farm;
use Illuminate\Database\Eloquent\Collection;

class FarmRepository implements FarmRepositoryInterface
{
    /**
     * すべてのファーム情報を取得する
     * @return Collection<Farm>
     */
    public function getAllFarms(): Collection
    {
        return Farm::get();
    }

    /**
     * 指定したIDのファーム詳細を取得する
     * レビュー情報（reviews）と州情報（state）も同時に取得する。
     * @param list<string>
     * @return Farm ファームID,state,あればreviews
     * @throws ModelNotFoundException 例外時404が表示される
     */
    public function getDetailById(int $id, array $relations = []): Farm
    {
        return Farm::with($relations)->findOrFail($id);
    }
}
