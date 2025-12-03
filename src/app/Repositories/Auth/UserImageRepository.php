<?php

namespace App\Repositories\Auth;

use App\Repositories\Auth\UserImageRepositoryInterface;
use App\Models\UserImage;

class UserImageRepository implements UserImageRepositoryInterface
{
    /**
     * ユーザー画像登録
     * @param array $imageData
     */
    public function registerImage(array $imageData): void
    {
        UserImage::insert($imageData);
    }

    /**
     * ユーザー画像取得
     * @param int $id
     * @return UserImage
     */
    public function getImage(int $id): UserImage
    {
        $image = UserImage::where('user_id', $id)->first();

        return $image;
    }

    /**
     * ユーザー画像更新
     * @param array $imageData
     * @param UserImage $previousImage
     */
    public function updateImage(array $imageData, UserImage $previousImage): void
    {
        $previousImage->update($imageData);

        $previousImage->refresh();
    }
}
