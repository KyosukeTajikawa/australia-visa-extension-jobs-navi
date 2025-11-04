<?php

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

    //レビュー
    Route::get('/farm/{id}/review/create', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/farm/{id}/review', [ReviewController::class, 'store'])->name('review.store');
    Route::get('/review/favorites', [ReviewController::class, 'favorites'])->name('review.favorites');
    Route::post('/review/{review}/favorites', [ReviewController::class, 'favoritesStore'])->name('favorites.store');
    Route::delete('/review/{review}/favorites', [ReviewController::class, 'favoritesDestroy'])
        ->name('review.favorites.destroy');
});

require __DIR__ . '/auth.php';
