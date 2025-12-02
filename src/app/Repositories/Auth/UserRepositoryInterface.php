<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Models\UserImage;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * ユーザー登録
     * @param array $validated
     * @return User
     */
    public function registerUser(array $validated): User;

    /**
     * ユーザー情報取得
     * @return User
     */
    public function getUser(): User;

    /**
     * ユーザー更新
     * @param array $validated
     * @param User $user
     * @return User
     */
    public function updateUser(array $validated, User $previousUser): User;

    /**
     * ユーザー画像削除
     * @param int $id
     * @return UserImage
     */
    public function getImage(int $id): UserImage;

    /**
     * ユーザー削除
     */
    public function destroyUser(): void;
}
