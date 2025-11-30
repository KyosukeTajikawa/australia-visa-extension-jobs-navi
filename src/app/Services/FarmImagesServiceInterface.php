<?php

namespace App\Services;

use App\Models\Farm;

interface FarmImagesServiceInterface
{
    /**
     * ファームの登録処理
     * @param Farm $farm
     * @param array $files 画像ファイル | null
     */
    public function imagesStore(Farm $farm, ?array $files = null):void ;

    /**
     * ファームの編集処理
     * @param Farm $farm
     * @param array $files 画像ファイル | null
     */
    public function imagesUpdate(Farm $farm, ?array $files = null): void;

    /**
     * ファーム画像を削除
     * @param int $id
     */
    public function destroy(int $id): void;
}
