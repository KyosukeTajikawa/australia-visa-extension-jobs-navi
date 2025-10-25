<?php

namespace App\Repositories;

interface FarmImageRepositoryInterface
{
    /**
     * 画像登録
     * @param array $fileStock 画像が３つまで配列である
     */
    public function registerFarmImage(array $filesStock): void;
}
