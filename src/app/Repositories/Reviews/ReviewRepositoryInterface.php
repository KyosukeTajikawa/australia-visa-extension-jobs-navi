<?php

namespace App\Repositories\Reviews;

use App\Models\Farm;
use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface ReviewRepositoryInterface
{
    /**
     * レビュー登録ページ
     * @param int $id
     * @return Farm
     */
    public function getCreateById(int $id): Farm;

    /**
     * レビューを登録
     * @param $validatedバリデーションをされた配列
     * @return Review 登録後のモデルインスタンス
     */
    public function registerReview(array $validated): Review;
}
