<?php

namespace App\Services;

use App\Models\Farm;
use App\Repositories\FarmRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class FarmService implements FarmServiceInterface
{
    /**
     * FarmController constructor
     * @param FarmRepositoryInterface $farmRepository ファーム情報を扱うリポジトリの実装
     */
    public function __construct(
        private readonly FarmRepositoryInterface $farmRepository,
    ) {}

    /**
     * ファームの登録処理
     * @param array $validated バリデーション済み
     * @param array $fiiles 画像ファイル | null
     * @return Farm
     */
    public function store(array $validated, ?array $files = null): Farm
    {


        DB::beginTransaction();
        try {

            $farm = $this->farmRepository->registerFarm($validated);
            // $farm = Farm::create($validated);

            // dd($farm);

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

                $FarmImages = $this->farmRepository->registerFarmImage($filesStock);

                dd($FarmImages);


                // FarmImages::insert($filesStock);

            }
            DB::commit();
            return $farm;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::error($message);
            DB::rollBack();
            throw $e;
        }
    }
}
