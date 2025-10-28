<?php

namespace App\Repositories;

use App\Models\FarmImages;
use App\Repositories\FarmImageRepositoryInterface;

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
}
