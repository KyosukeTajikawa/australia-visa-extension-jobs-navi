<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Models\UserImage;
use Illuminate\Database\Eloquent\Collection;

interface UserImageRepositoryInterface
{
    /**
     * ユーザー画像登録
     * @param array $imageData
     */
    public function registerImage(array $imageData): void;

    /**
     * ユーザー画像取得
     * @param User $user
     * @return UserImage
     */
    public function getImage(User $user): UserImage;

    /**
     * ユーザー画像更新
     * @param array $imageData
     * @param UserImage $previousImage
     */
    public function updateImage(array $imageData, UserImage $previousImage): void;
}
