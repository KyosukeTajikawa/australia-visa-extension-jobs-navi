<?php

namespace App\Repositories\Auth;

use App\Models\User;
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
     * ユーザー更新
     * @param array $validated
     * @param User $user
     */
    public function updateUser(array $validated, User $user): void;
}
