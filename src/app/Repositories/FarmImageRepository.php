<?php

namespace App\Repositories;

use App\Models\FarmImages;
use App\Repositories\FarmImageRepositoryInterface;

class FarmImageRepository implements FarmImageRepositoryInterface
{
    /**
     * 画像登録
     * @param array $fileStock 画像が３つまで配列である
     */
    public function registerFarmImage(array $filesStock): void
    {
        FarmImages::insert($filesStock);
    }
}
