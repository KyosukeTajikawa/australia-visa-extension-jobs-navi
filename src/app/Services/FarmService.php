<?php

namespace App\Services;

use App\Models\Farm;
use App\Repositories\FarmRepositoryInterface;
use App\Services\FarmImagesServiceInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FarmService implements FarmServiceInterface
{
    /**
     * FarmService constructor
     * @param FarmRepositoryInterface $farmRepository ファーム情報を扱うリポジトリの実装
     * @param FarmImagesServiceInterface $farmImagesService ファーム画像を扱うリポジトリの実装
     */
    public function __construct(
        private readonly FarmRepositoryInterface $farmRepository,
        private readonly FarmImagesServiceInterface $farmImagesService
    ) {}

    /**
     * ファームの登録処理
     * @param array $farmData 作物以外のtextデータ
     * @param array $cropData 作物のみのtextデータ
     * @param array $files 画像ファイル | null
     * @return Farm
     */
    public function store(array $farmData, array $cropData, ?array $files = null): Farm
    {
        DB::beginTransaction();
        try {
            $farm = $this->farmRepository->registerFarm($farmData);

            $this->farmImagesService->imagesStore($farm, $files);

            $this->farmRepository->registerFarmCrops($farm, $cropData);

            DB::commit();

            return $farm;
        } catch (\Exception $e) {
            Log::error(__METHOD__ . 'ファームの登録処理でエラーが発生しました。' . $e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }
}
