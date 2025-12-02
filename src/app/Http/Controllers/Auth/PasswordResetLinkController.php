<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    /**
     * メールリセットリンク送信画面
     * @return Response
     */
    public function create(): Response
    {
        //送信完了時のSessionに入るstatusを渡す
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    /**
     * リクエストリンクス送信.
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // 入力メールアドレスが登録されているメールアドレスと同じか確認しあっていたらトークンを発行しリンクを送信
        $status = Password::sendResetLink(
            $request->only('email')
        );

        //あれば送信してstatusを渡す
        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        //なければバリデーションメッセージ表示
        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}
