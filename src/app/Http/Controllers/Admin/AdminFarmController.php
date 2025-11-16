<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Farms\FarmStoreRequest;
use App\Models\Farm;
use App\Repositories\Farms\FarmRepositoryInterface;
use App\Repositories\StateRepositoryInterface;
use App\Services\FarmServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class AdminFarmController extends Controller
{
    /**
     * FarmController constructor
     * @param FarmRepositoryInterface $farmRepository ファーム情報を扱うリポジトリの実装
     * @param StateRepositoryInterface $stateRepository 州情報を扱うリポジトリの実装
     * @param FarmServiceInterface $farmService ファーム情報を扱うサービスの実装
     */
    public function __construct(
        private readonly FarmRepositoryInterface $farmRepository,
        private readonly StateRepositoryInterface $stateRepository,
        private readonly FarmServiceInterface $farmService
    ) {}

    /**
     * ファーム新規作成のページを表示
     * @param $id
     * @return Response
     */
    public function edit($id): Response
    {
        $farm = $this->farmRepository->getDetailById($id, ['state', 'crops', 'images']);

        $crops = $this->farmRepository->getCrops();

        $states = $this->stateRepository->getAll();

        return Inertia::render('Admin/FarmEdit', [
            'farm' => $farm,
            'states' => $states,
            'crops'  => $crops,
        ]);
    }

    /**
     * ファームの新規登録
     * @param FarmStoreRequest $request
     * @return RedirectResponse
     */
    public function update(FarmStoreRequest $request, int $id): RedirectResponse
    {
        $validated = $request->validated();

        $farmData = Arr::except($validated, ['crop_ids']);
        $cropData = array_map('intval', $validated['crop_ids']);
        $files    = $request->file('files');

        $farm = $this->farmService->update($farmData, $cropData, $files, $id);

        return redirect()->route('user.detail', [
            'id' => $farm->created_user_id,
        ]);
    }

    public function destroy($id)
    {
        $farm = Farm::with(['images', 'reviews.reviewComments', 'reviews.favoritedUsers'])
            ->findOrFail($id);

        $createdUserId = $farm->created_user_id;

        // 画像削除
        foreach ($farm->images as $image) {
            Storage::disk('s3')->delete($image->path);
            $image->delete();
        }

        // レビュー関連削除
        foreach ($farm->reviews as $review) {
            // お気に入り（中間テーブル）削除
            $review->favoritedUsers()->detach();

            // コメント削除
            $review->reviewComments()->delete();

            // レビュー本体削除
            $review->delete();
        }

        // ファーム削除
        $farm->delete();

        return redirect()->route('user.detail', ['id' => $createdUserId]);
    }
}
