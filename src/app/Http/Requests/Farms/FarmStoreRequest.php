<?php

namespace App\Http\Requests\Farms;

use Illuminate\Foundation\Http\FormRequest;

class FarmStoreRequest extends FormRequest
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
        return             [
            'name'            => ['required', 'string', 'max:50'],
            'phone_number'    => ['nullable', 'string', 'regex:/^\d{10,11}$/'],
            'email'           => ['nullable', 'email:rfc', 'max:255'],
            'street_address'  => ['required', 'string', 'max:100'],
            'suburb'          => ['required', 'string', 'max:50'],
            'postcode'        => ['required',  'digits:4'],
            'state_id'        => ['required', 'integer', 'exists:states,id'],
            'description'     => ['nullable', 'string', 'max:1000'],
            'files'           => ['nullable', 'array', 'max:3'],
            'files.*'         => ['image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'created_user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    /**
     * バリデーションエラーメッセージ
     * @return array
     */
    public function messages(): array
    {
        return             [
            'name.required'           => 'ファーム名は必須です。',
            'phone_number.regex'      => '電話番号はハイフンなしの数字10桁,11桁で入力してください。',
            'email.email'             => 'メールアドレスの形式が正しくありません。',
            'street_address.required' => '住所を入力してください。',
            'suburb.required'         => '地域を入力してください。',
            'postcode.required'       => '郵便番号は必須です。',
            'postcode.digits'         => '郵便番号は4桁の数字で入力してください。',
            'state_id.required'       => '州を選択してください。',
            'files.*.image'            => '画像ファイルを選択してください。',
            'files.*.mimes'            => 'jpg/jpeg/png のいずれかを選択してください。',
            'files.*.max'              => '画像サイズは5MB以下にしてください。',
        ];
    }

    /**
     * バリデーション前の入力値を整形
     */
    protected function prepareForValidation(): void
    {
        //ユニーク制約、かつ、任意（nullable）なので空文字をnullに変換
        $this->merge([
            'name' => $this->filled('name') ? trim((string)$this->input('name')) : null,
            'phone_number' => $this->filled('phone_number') ? $this->input('phone_number') : null,
            'email' => $this->filled('email') ? trim((string)$this->input('email')) : null,
            'created_user_id' => auth()->id(),
        ]);
    }
}
