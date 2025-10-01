<?php

namespace App\Repositories;

use App\Models\Farm;
use App\Models\State;
use App\Interfaces\FarmRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;


/**
 * すべてのファーム情報を取得する
 * @return Collection<Farm>
 */
class FarmRepository implements FarmRepositoryInterface
{
    public function getAllFarms(): Collection
    {
        return Farm::get();
    }

    /**
     * 指定したIDのファーム詳細を取得する
     * レビュー情報（reviews）と州情報（state）も同時に取得する。
     * @param array<string, mixed> $relations リレーション名
     * @return Farm|null
     */
    public function getDetailById(int $id, array $relations = []): ?Farm
    {
        return Farm::with($relations)->findOrFail($id);
    }

    /**
     * すべてのファーム情報を取得する
     * @return Collection<State>
     */
    public function getStates(): Collection
    {
        return State::get();
    }
}
