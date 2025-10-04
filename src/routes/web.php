<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FarmController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// 認証テスト
Route::get('/login-test', function () {
    return Inertia::render('LoginTest');
});

// ホーム画面
Route::get('/home', [FarmController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {});

//ファーム
Route::get('/farm/{id}', [FarmController::class, 'detail'])->name('farm.detail');

//以下はログアウト機能が作成できた後に削除する。
//今はこれがないとhomeにリダイレクトされてloginが開けないため。
// Route::middleware('guest')->group(function () {
//ログイン
    Route::get('/login',  [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
// });

Route::middleware('auth')->group(function () {
    // ログアウト
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

// require __DIR__.'/auth.php';
