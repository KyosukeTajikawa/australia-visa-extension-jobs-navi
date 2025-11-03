<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface FarmImageRepositoryInterface
{
    /**
     * 画像登録
     * @param array $insertValues
     */
    public function bulkInsert(array $insertValues): void;

    /**
     * ファームidに紐ずく画像取得
     * @param int $farmId
     * @return Collection
     */
    public function getByFarmId(int $farmId): Collection;

    /**
     * ファームidに紐ずく画像削除
     * @param int $farmId
     */
    public function deleteByFarmId(int $farmId): void;
}
