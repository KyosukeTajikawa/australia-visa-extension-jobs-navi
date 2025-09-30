<?php

namespace App\Repositories;

use App\Models\Farm;
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
     * @param int $id 取得したいファームのID
     * @return Farm|null 該当するFarmモデル。存在しない場合はnull
     */
    public function getDetailById(int $id)
    {
        return Farm::with('reviews', 'state')->find($id);
    }
}
