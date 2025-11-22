<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserImage;
use App\Repositories\Auth\UserImageRepositoryInterface;
use App\Services\UserImageServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserImageService implements UserImageServiceInterface
{

    /**
     * FarmImagesService constructor
     * @param FarmImageRepositoryInterface $farmImagesService ファーム画像を扱うリポジトリの実装
     */
    public function __construct(
        private readonly UserImageRepositoryInterface $userImageRepository,
    ) {}

    /**
     * ユーザーの登録処理
     * @param User $user
     * @param UploadedFile $file
     */
    public function imageStore(User $user, ?UploadedFile $file = null): void
    {
        if (!$file) {
            return;
        }

        $name = $file->getClientOriginalName();
        $path = Storage::disk('s3')->putFileAs("users/{$user->id}", $file, $name);
        $url = Storage::disk('s3')->url($path);

        $imageData = [
            'user_id' => $user->id,
            'url' => $url,
            'path' => $path,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $this->userImageRepository->registerImage($imageData);
    }

    /**
     * ユーザーの更新処理
     * @param User $user
     * @param UploadedFile $file
     */
    public function imageUpdate(User $user, ?UploadedFile $file = null): void
    {
        if (!$file) {
            return;
        }

        $previousImage = $this->userImageRepository->getImage($user);

        Storage::disk('s3')->delete($previousImage->path);

        $name = $file->getClientOriginalName();
        $path = Storage::disk('s3')->putFileAs("users/{$user->id}", $file, $name);
        $url = Storage::disk('s3')->url($path);

        $imageData = [
            'user_id' => $user->id,
            'url' => $url,
            'path' => $path,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $this->userImageRepository->updateImage($imageData, $previousImage);
    }

}
