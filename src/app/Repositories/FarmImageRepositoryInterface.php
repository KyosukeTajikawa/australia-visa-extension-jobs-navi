<?php

namespace App\Repositories;

interface FarmImageRepositoryInterface
{
    /**
     * 画像登録
     * @param array $insertValues
     */
    public function bulkInsert(array $insertValues): void;
}
