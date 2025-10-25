<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FarmController;
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
});

//ログイン
    Route::get('/login',  [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

Route::middleware('auth')->group(function () {
    // ログアウト
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
