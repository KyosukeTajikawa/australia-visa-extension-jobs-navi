<?php

namespace App\Repositories;

use App\Models\FarmImages;
use App\Repositories\FarmImageRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FarmImageRepository implements FarmImageRepositoryInterface
{
    /**
     * 画像登録
     * @param array $insertValues
     */
    public function bulkInsert(array $insertValues): void
    {
        FarmImages::insert($insertValues);
    }

    /**
     * ファームidに紐ずく画像取得
     * @param int $farmId
     * @return Collection
     */
    public function getByFarmId(int $farmId): Collection
    {
        return FarmImages::where('farm_id', $farmId)->get();
    }

    /**
     * ファームidに紐ずく画像削除
     * @param int $farmId
     */
    public function deleteByFarmId(int $farmId): void
    {
        FarmImages::where('farm_id', $farmId)->delete();
    }
}
