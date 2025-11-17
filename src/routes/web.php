<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminFarmController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\FarmController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// 認証テスト
Route::get('/login-test', function () {
    return Inertia::render('LoginTest');
});

// ホーム画面
Route::get('/home', [FarmController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    //ファーム
    Route::get('/farm/create', [FarmController::class, 'create'])->name('farm.create');
    Route::post('/farm/store', [FarmController::class, 'store'])->name('farm.store');
    Route::get('/farm/myFarms', [FarmController::class, 'myFarms'])->name('farm.myFarms');
    Route::get('/farm/{id}', [FarmController::class, 'detail'])->name('farm.detail');
    Route::get('/farm/{id}/edit', [FarmController::class, 'edit'])->name('farm.edit');
    Route::put('/farm/{id}/update', [FarmController::class, 'update'])->name('farm.update');
    Route::delete('/farm/{id}/destroy', [FarmController::class, 'destroy'])->name('farm.image.destroy');


    //レビュー
    Route::get('/farm/{id}/review/create', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/farm/{id}/review', [ReviewController::class, 'store'])->name('review.store');
    Route::get('/review/favorites', [ReviewController::class, 'favorites'])->name('review.favorites');
    Route::post('/review/{review}/favorites', [ReviewController::class, 'favoritesStore'])->name('favorites.store');
    Route::delete('/review/{review}/favorites', [ReviewController::class, 'favoritesDestroy'])->name('review.favorites.destroy');
    Route::post('/review/{review}/reviewComment', [ReviewController::class, 'reviewCommentStore'])->name('reviewComment.store');

    //プロフィール
    Route::get('/profile', [RegisteredUserController::class, 'index'])->name('profile');
});

Route::prefix('admin')->middleware(['auth',])->group(
    function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        //ユーザー
        Route::get('/user', [AdminUserController::class, 'index'])->name('user');
        Route::get('/user/{id}', [AdminUserController::class, 'detail'])->name('user.detail');

        // ファーム
        Route::get('/farm/{id}/edit', [AdminFarmController::class, 'edit'])->name('admin.farm.edit');
        Route::put('/farm/{id}/update', [AdminFarmController::class, 'update'])->name('admin.farm.update');
        Route::delete('/farm/{id}/destroy', [AdminFarmController::class, 'destroy'])->name('admin.farm.destroy');

        //レビュー
        Route::get('/review/{id}/edit', [AdminReviewController::class, 'edit'])->name('admin.review.edit');
        Route::put('/review/{id}/update', [AdminReviewController::class, 'update'])->name('admin.review.update');
        Route::delete('/review/{id}/destroy', [AdminReviewController::class, 'destroy'])->name('admin.review.destroy');
    }
);

require __DIR__ . '/auth.php';
