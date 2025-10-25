<?php

namespace App\Services;

use App\Models\Farm;

interface FarmServiceInterface
{
    /**
     * ファームの登録処理
     * @param array $validated
     * @param array $files 画像ファイル | null
     * @return Farm
     */
    public function store(array $validated, ?array $files = null): Farm;
}
