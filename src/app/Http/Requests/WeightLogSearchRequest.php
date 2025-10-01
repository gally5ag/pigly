<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeightLogSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from_date' => ['nullable', 'date'],
            'to_date'   => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'from_date.required' => '開始日を入力してください',
            'to_date.required'   => '終了日を入力してください',
            'to_date.after_or_equal' => '終了日は開始日以降の日付を選択してください',
        ];
    }
}
