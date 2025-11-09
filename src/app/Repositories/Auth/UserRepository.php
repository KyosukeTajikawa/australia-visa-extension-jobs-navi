<?php

namespace App\Repositories\Auth;

use App\Repositories\Auth\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    /**
     * ユーザー登録
     * @param array $validated
     * @return User
     */
    public function registerUser(array $validated): User
    {
        return User::create([
            'nickname' => $validated['nickname'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'gender' => $validated['gender'],
            'birthday' => $validated['birthday'],
        ]);
    }

    /**
     * ユーザー更新
     * @param array $validated
     * @param User $user
     */
    public function updateUser(array $validated, User $user): void
    {
        $user->update($validated);

        $user->refresh();
    }
}
