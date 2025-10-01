<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeightLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date'           => ['required', 'date'],
            'weight'         => [
                'required',
                'regex:/^\d{1,4}(\.\d)?$/'
            ],
            'calories'        => ['required', 'numeric'],
            'exercise_time'  => ['required'], // input type="time"（HH:MM）
            'exercise_content'  => ['nullable', 'max:120'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.required'          => '日付を入力してください',

            'weight.required'        => '体重を入力してください',
            'weight.regex'           => '4桁までの数字で入力してください', // 小数1桁も兼ねる
            'weight.numeric'         => '数字で入力してください', // 予備（regex優先）

            'calories.required'       => '摂取カロリーを入力してください',
            'calorie.numeric'        => '数字で入力してください',

            'exercise_time.required' => '運動時間を入力してください',

            'exercise_content'      => '120文字以内で入力してください',
        ];
    }
}
