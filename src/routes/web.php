<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
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
    Route::get('/farm/{id}', [FarmController::class, 'detail'])->name('farm.detail');

    //レビュー
    Route::get('/farm/{id}/review/create', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/farm/{id}/review', [ReviewController::class, 'store'])->name('review.store');
});

require __DIR__ . '/auth.php';
