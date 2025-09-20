<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * 動作確認用
 * GET /api/ping -> {"pong":true}
 */
Route::get('/ping', fn() => response()->json(['pong' => true]));

/**
 * 認証が必要な例
 * ログイン後に GET /api/user で現在のユーザーを返す
 */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
