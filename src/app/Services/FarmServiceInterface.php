<?php

namespace App\Services;

use App\Models\Farm;

interface FarmServiceInterface
{
    /**
     * ファームの登録処理
     * @param array $farmData 作物以外のtextデータ
     * @param array $cropData 作物のみのtextデータ
     * @param array $files 画像ファイル | null
     * @return Farm
     */
    public function store(array $farmData, array $cropData, ?array $files = null): Farm;

    /**
     * ファームの登録処理
     * @param array $farmData 作物以外のtextデータ
     * @param array $cropData 作物のみのtextデータ
     * @param array $files 画像ファイル | null
     * @param int $id
     * @return Farm
     */
    public function update(array $farmData, array $cropData, ?array $files = null, int $id): Farm;
}
