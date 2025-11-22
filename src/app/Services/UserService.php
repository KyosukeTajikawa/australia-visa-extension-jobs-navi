<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Auth\UserRepositoryInterface;
use App\Services\UserImageServiceInterface;
use App\Services\UserServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserService implements UserServiceInterface
{
    /**
     * FarmService constructor
     * @param UserRepositoryInterface $userRepository ユーザー情報を扱うリポジトリの実装
     * @param UserImageServiceInterface $userImageService ユーザー画像を扱うサービスの実装
     */
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserImageServiceInterface $userImageService
    ) {}

    /**
     * ユーザーの登録処理
     * @param array $validated
     * @param UploadedFile $file
     * @return User
     */
    public function store(array $validated, ?UploadedFile $file = null): User
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->registerUser($validated);

            $this->userImageService->imageStore($user, $file);

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            Log::error(__METHOD__ . 'ファームの登録処理でエラーが発生しました。' . $e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * ユーザーの編集処理
     * @param array $validated
     * @param UploadedFile $file
     * @return User
     */
    public function update(array $validated, ?UploadedFile $file = null): User
    {
        DB::beginTransaction();
        try {
            $previousUser = $this->userRepository->getUser();

            $user = $this->userRepository->updateUser($validated, $previousUser);

            $this->userImageService->imageUpdate($user, $file);

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            Log::error(__METHOD__ . 'ファームの登録処理でエラーが発生しました。' . $e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }
}
