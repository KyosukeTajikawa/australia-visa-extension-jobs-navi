<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;

interface UserServiceInterface
{
    /**
     * ユーザーの登録処理
     * @param array $validated
     * @param UploadedFile $file
     * @return User
     */
    public function store(array $validated, ?UploadedFile $file = null): User;

    /**
     * ユーザーの編集処理
     * @param array $validated
     * @param UploadedFile $file
     * @return User
     */
    public function update(array $validated, ?UploadedFile $file = null): User;
}
