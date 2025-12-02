<?php

namespace App\Http\Requests\Reviews;

use Illuminate\Foundation\Http\FormRequest;

class ReviewStoreRequest extends FormRequest
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
            'work_position'   => ['required', 'string', 'max:50'],
            'hourly_wage'     => ['nullable', 'required_if:pay_type,1', 'numeric', 'between:0,99.9'],
            'pay_type'        => ['required', 'integer', 'in:1,2'],
            'is_car_required' => ['required', 'integer', 'in:1,2'],
            'start_date'      => ['required', 'date_format:Y-m-d'],
            'end_date'        => ['nullable', 'date_format:Y-m-d', 'after_or_equal:start_date'],
            'application_method_id' => ['required', 'integer', 'exists:application_methods,id'],
            'application_method_other' => ['exclude_unless:application_method_id,99', 'required', 'string'],
            'farm_rating'  => ['required', 'integer', 'between:1,5'],
            'comment'         => ['required', 'string', 'max:1000'],
            'farm_id'         => ['required', 'integer', 'exists:farms,id'],
        ];
    }

    /**
     * バリデーションエラーメッセージ
     * @return array
     */
    public function messages(): array
    {
        return             [
            'work_position.required' => '仕事のポジションは必須です。',
            'work_position.max' => '仕事のポジションは50文字以内で入力してください。',
            'hourly_wage.required_if' => '支払種別が「時給」の場合、時給は必須です。',
            'hourly_wage.numeric'     => '時給は数値で入力してください。',
            'hourly_wage.between'     => '時給は0〜99.9の範囲で入力してください。',
            'start_date.date_format' => '開始日は「YYYY-MM-DD」の形式で入力してください。',
            'end_date.date_format' => '終了日は「YYYY-MM-DD」の形式で入力してください。',
            'end_date.after_or_equal' => '終了日は開始日以降の日付を指定してください。',
            'application_method_other.required' => 'その他を選択した場合は入力してください。',
            'comment.max' => 'コメントは1000文字以内で入力してください。',
        ];
    }

    /**
     * バリデーション前の入力値を整形
     */
    public function prepareForValidation(): void
    {
        if ($this->has('hourly_wage')) {
            $value = $this->input('hourly_wage');

            if ($value === '' || $value === null) {
                $this->merge(['hourly_wage' => null]);
            } else {
                $normalized = trim($value);

                $normalized = mb_convert_kana($normalized, 'n');

                $this->merge(['hourly_wage' => $normalized]);
            }
        }

        if ($this->input('end_date') === '') {
            $this->merge(['end_date' => null]);
        }
    }
}
