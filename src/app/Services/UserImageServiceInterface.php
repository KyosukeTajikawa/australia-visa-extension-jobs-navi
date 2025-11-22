<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;

interface UserImageServiceInterface
{
    /**
     * ユーザーの登録処理
     * @param User $user
     * @param UploadedFile $file
     */
    public function imageStore(User $user, ?UploadedFile $file = null): void;

    /**
     * ユーザーの更新処理
     * @param User $user
     * @param UploadedFile $file
     */
    public function imageUpdate(User $user, ?UploadedFile $file = null): void;
}
