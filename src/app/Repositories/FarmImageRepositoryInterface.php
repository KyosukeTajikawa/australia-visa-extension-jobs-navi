<?php

namespace App\Repositories;

interface FarmImageRepositoryInterface
{
    /**
     * 画像登録
     * @param array $insertValues 画像が３つまで配列である
     */
    public function bulkInsert(array $insertValues): void;
}
