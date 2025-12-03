<?php

namespace App\Repositories\Auth;

use App\Repositories\Auth\UserRepositoryInterface;
use App\Models\User;
use App\Models\UserImage;
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
     * ユーザー情報取得
     * @return User
     */
    public function getUser(array $relation = []): User
    {
        return User::with($relation)->findOrFail(auth()->id());
    }

    /**
     * ユーザー更新
     * @param array $validated
     * @param User $user
     * @return User
     */
    public function updateUser(array $validated, User $previousUser): User
    {
        $previousUser->update($validated);

        return $previousUser->refresh();
    }

    /**
     * ユーザー削除
     */
    public function destroyUser():void
    {
        $user = auth()->user();

        $user->delete();
    }
}
