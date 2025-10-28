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
}
