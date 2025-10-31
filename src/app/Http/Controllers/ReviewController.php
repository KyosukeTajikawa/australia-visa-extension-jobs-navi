<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reviews\ReviewStoreRequest;
use App\Models\Review;
use App\Repositories\Reviews\ReviewRepositoryInterface;
use Illuminate\Http\RedirectResponse;
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
    ){}

    /**
     * ファーム新規作成のページを表示
     * @return Response
     */
    public function create(int $id): Response
    {
        $farm = $this->reviewRepository->getCreateById($id);

        return Inertia::render('Review/Create',[
            'farm' => $farm,
        ]);
    }

    /**
     * ファームの新規登録
     * @param FarmStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ReviewStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $review = $this->reviewRepository->registerReview($validated);

        return redirect()->route('farm.detail', [
            'id' => $review->farm_id,
        ]);
    }

    /**
     * ファームの新規登録
     * @return Response
     */
    public function favorites(): Response
    {
        $reviews = $this->reviewRepository->getFavoriteReviews();

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

        return redirect()->route('review.favorites');
    }
}
