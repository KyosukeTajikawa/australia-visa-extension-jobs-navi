<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Farms\FarmStoreRequest;
use App\Http\Requests\Reviews\ReviewStoreRequest;
use App\Models\ApplicationMethod;
use App\Models\Farm;
use App\Models\Review;
use App\Repositories\Farms\FarmRepositoryInterface;
use App\Repositories\Reviews\ReviewRepositoryInterface;
use App\Repositories\StateRepositoryInterface;
use App\Services\FarmServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class AdminReviewController extends Controller
{
    /**
     * FarmController constructor
     * @param ReviewRepositoryInterface $farmRepository ファーム情報を扱うリポジトリの実装
     */
    public function __construct(
        private readonly ReviewRepositoryInterface $reviewRepository,
    ) {}

    /**
     * レビュー編集ページを表示
     * @param $id
     * @return Response
     */
    public function edit($id): Response
    {
        $review = Review::findOrFail($id);
        $applicationMethods = ApplicationMethod::orderBy('id')->get();


        return Inertia::render('Admin/ReviewEdit', [
            'review' => $review,
            'applicationMethods' => $applicationMethods,
        ]);
    }

    /**
     * レビュー編集
     * @param ReviewStoreRequest $request
     * @param  int $id
     * @return RedirectResponse
     */
    public function update(ReviewStoreRequest $request, int $id): RedirectResponse
    {
        // dd($request->all());
        $review = Review::findOrFail($id);

        $validated = $request->validated();

        $validated['user_id'] = $review->user_id;

        $review->update($validated);

        return redirect()->route('user.detail', [
            'id' => $review->user_id,
        ]);
    }

    /**
     * レビューの削除
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $review = Review::with(['reviewComments', 'favoritedUsers'])->findOrFail($id);

        $review->favoritedUsers()->detach();

        $review->reviewComments()->delete();

        $review->delete();

        return redirect()->route('user.detail', ['id' => $review->user_id]);
    }
}
