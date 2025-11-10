<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;


class UserStoreRequest extends FormRequest
{
    /**
     * ユーザーの権限チェック
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションチェック
     * @return array
     */
    public function rules(): array
    {
        return [
            'nickname' => ['required','string','max:255'],
            'email' => ['required', 'string','lowercase','email','max:255','unique:' . User::class],
            'gender'        => ['required', 'integer', 'in:1,2'],
            'birthday'      => ['nullable', 'date', 'date_format:Y-m-d'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }

    /**
     * バリデーションエラーメッセージ
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.email' => '有効なメールアドレス形式で入力してください。',
            'birthday.date_format' => '生年月日はformatの形式と一致していません。',
            'birthday.date' => '生年月日はYYYY/MM/DDで入力してください。',
            'password' => 'パスワードの確認が一致しません。',
        ];
    }
}
