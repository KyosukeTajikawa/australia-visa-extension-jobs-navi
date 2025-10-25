<?php

namespace App\Repositories;

use App\Models\FarmImages;
use App\Repositories\FarmImageRepositoryInterface;

class FarmImageRepository implements FarmImageRepositoryInterface
{
    /**
     * 画像登録
     * @param array $insertValues 画像が３つまで配列である
     */
    public function bulkInsert(array $insertValues): void
    {
        FarmImages::insert($insertValues);
    }
}
