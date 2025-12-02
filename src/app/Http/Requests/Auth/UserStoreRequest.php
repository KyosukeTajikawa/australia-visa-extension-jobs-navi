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
            'file' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'nickname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
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
            'files.image'           => '画像ファイルを選択してください。',
            'file.mimes'           => 'jpg/jpeg/png のいずれかを選択してください。',
            'file.max'              => '画像のサイズは2MB以下にしてください。',
            'email.email' => '有効なメールアドレス形式で入力してください。',
            'birthday.date_format' => '生年月日はformatの形式と一致していません。',
            'birthday.date' => '生年月日はYYYY/MM/DDで入力してください。',
            'password' => 'パスワード確認が一致しません。',
        ];
    }

    /**
     * バリデーション前の入力値を整形
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'birthday' => $this->filled('birthday') ? $this->input('birthday') : null,
        ]);
    }
}
