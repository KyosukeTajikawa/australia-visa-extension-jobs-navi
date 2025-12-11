<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            'file' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:52400'],
            'nickname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user()->id)],
            'gender'        => ['required', 'integer', 'in:1,2'],
            'birthday'      => ['nullable', 'date', 'date_format:Y-m-d'],
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
