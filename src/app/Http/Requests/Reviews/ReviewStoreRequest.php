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
            'hourly_wage'     => ['nullable', 'required_if:pay_type,1', 'regex:/^\d{1,2}(\.\d)?$/'],
            'pay_type'        => ['required', 'integer', 'in1,2'],
            'is_car_required' => ['required', 'integer', 'in1,2'],
            'start_date'      => ['required', 'date_format:Y-m-d'],
            'end_date'        => ['nullable', 'date_format:Y-m-d', 'after_or_equal:start_date'],
            'work_rating'     => ['required', 'integer', 'between:1,5'],
            'salary_rating'   => ['required', 'integer', 'between:1,5'],
            'hour_rating'     => ['required', 'integer', 'between:1,5'],
            'relation_rating' => ['required', 'integer', 'between:1,5'],
            'overall_rating'  => ['required', 'integer', 'between:1,5'],
            'comment'         => ['required', 'string', 'max:1000'],
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
            'hourly_wage.numeric' => '時給は数値で入力してください。',
            'hourly_wage.regex' => '時給は整数2桁または小数1桁までで入力してください（例: 12.3）。',
            'start_date.date_format' => '開始日は「YYYY-MM-DD」の形式で入力してください。',
            'end_date.date_format' => '終了日は「YYYY-MM-DD」の形式で入力してください。',
            'end_date.after_or_equal' => '終了日は開始日以降の日付を指定してください。',
            'comment.max' => 'コメントは1000文字以内で入力してください。',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => auth()->id(),
        ]);
    }
}
