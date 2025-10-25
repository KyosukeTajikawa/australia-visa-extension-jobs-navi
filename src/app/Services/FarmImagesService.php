<?php

namespace App\Services;

use App\Models\Farm;
use App\Repositories\FarmImageRepositoryInterface;
use App\Repositories\FarmRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FarmImagesService implements FarmImagesServiceInterface
{
    public function __construct(
        private readonly FarmRepositoryInterface $farmRepository,
        private readonly FarmImageRepositoryInterface $farmImageRepository,
    ) {}

    /**
     * ファームの登録処理
     * @param Farm $farm
     * @param array $files 画像ファイル | null
     */
    public function imagesStore(Farm $farm, ?array $files = null): void
    {
        if (!$files) {
            return;
        }
            $insertValues = [];

            foreach ($files as $file) {
                $extension = $file->guessExtension() ?: $file->getClientOriginalExtension() ?: 'bin';

                $name = Str::uuid()->toString() . '.' . $extension;

                $path = Storage::disk('s3')->putFileAs("farms/{$farm->id}", $file, $name);

                $url = Storage::disk('s3')->url($path);

                $insertValues[] = [
                    'farm_id'    => $farm->id,
                    'url'        => $url,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            $this->farmImageRepository->registerFarmImage($insertValues);
    }
}
