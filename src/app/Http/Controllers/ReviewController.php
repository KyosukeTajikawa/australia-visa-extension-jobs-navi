<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reviews\ReviewStoreRequest;
use App\Models\ApplicationMethod;
use App\Models\Review;
use App\Repositories\Reviews\ReviewRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ReviewController extends Controller
{
    /**
     * FarmController constructor
     * @param ReviewRepositoryInterface $farmRepository ファーム情報を扱うリポジトリの実装
     */
    public function __construct(
        private readonly ReviewRepositoryInterface $reviewRepository,
    ) {}

    /**
     * ファーム新規作成のページを表示
     * @return Response
     */
    public function create(int $id): Response
    {
        $farm = $this->reviewRepository->getCreateById($id);

        $applicationMethods = ApplicationMethod::orderBy('id')->get();

        return Inertia::render('Review/Create', [
            'farm' => $farm,
            'applicationMethods' => $applicationMethods,
        ]);
    }

    /**
     * レビューの登録
     * @param FarmStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ReviewStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        $review = $this->reviewRepository->registerReview($validated);

        return redirect()->route('farm.detail', [
            'id' => $review->farm_id,
        ]);
    }

    /**
     * お気に入りレビューページの表示
     * @return Response
     */
    public function favorites(): Response
    {
        $reviews = $this->reviewRepository->getFavoriteReviews(['farm']);

        return Inertia::render('Review/FavoriteReview', [
            'reviews' => $reviews,
        ]);
    }

    /**
     * お気に入りレビューの登録
     * @param Review $review
     * @return RedirectResponse
     */
    public function favoritesStore(Review $review): RedirectResponse
    {
        $this->reviewRepository->registerFavoriteReview($review);
        return back();
    }

    /**
     * お気に入りレビューの削除
     * @param Review $review
     * @return RedirectResponse
     */
    public function favoritesDestroy(Review $review): RedirectResponse
    {
        $this->reviewRepository->destroyFavoriteReview($review);
        return back();
    }

    /**
     * レビューコメントの登録
     * @param Request $request
     * @param Review $review
     * @return RedirectResponse
     */
    public function reviewCommentStore(Request $request, Review $review): RedirectResponse
    {
        $this->reviewRepository->registerReviewComment($request, $review);
        return back();
    }
}
