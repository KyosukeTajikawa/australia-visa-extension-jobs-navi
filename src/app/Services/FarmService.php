<?php

namespace App\Services;

use App\Models\Farm;
use App\Repositories\FarmRepositoryInterface;
use App\Services\FarmImagesServiceInterface;
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
     * @param array $validated
     * @param array $files 画像ファイル | null
     * @return Farm
     */
    public function store(array $validated, ?array $files = null): Farm
    {
        DB::beginTransaction();

        try {

            $farm = $this->farmRepository->registerFarm($validated);

            $this->farmImagesService->imagesStore($farm, $files);

            DB::commit();
            return $farm;
        } catch (\Exception $e) {
            Log::error(__METHOD__ . 'ファームの登録処理でエラーが発生しました。' . $e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }
}
