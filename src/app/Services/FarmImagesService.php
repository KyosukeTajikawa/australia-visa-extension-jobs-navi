<?php

namespace App\Services;

use App\Models\Farm;
use App\Repositories\FarmRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FarmImagesService implements FarmImagesServiceInterface
{
    public function __construct(
        private readonly FarmRepositoryInterface $farmRepository,
    ) {}

    /**
     * ファームの登録処理
     * @param Farm $farm
     * @param array $files 画像ファイル | null
     */
    public function imagesStore(Farm $farm, ?array $files = null): void
    {
        if ($files) {

            $filesStock = [];

            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $name = (string)Str::uuid() . '.' . $extension;
                $dir = "farms/{$farm->id}";

                $path = Storage::disk('s3')->putFileAs($dir, $file, $name, file_get_contents($file), ['visibility' => 'public']);

                /** @var \Illuminate\Filesystem\FilesystemAdapter $s3 */
                $s3 = Storage::disk('s3');
                $url = $s3->url($path);
                $filesStock[] = [
                    'farm_id'    => $farm->id,
                    'url'        => $url,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            $this->farmRepository->registerFarmImage($filesStock);
        }
    }
}
