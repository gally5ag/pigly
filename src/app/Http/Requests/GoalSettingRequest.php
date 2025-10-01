<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoalSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 例：60.0 のように「整数1〜3桁 + 小数1桁」を必須にする
            'target_weight' => [
                'required',
                'numeric',
                'regex:/^\d{1,4}(\.\d)?$/', // 小数は必ず1桁（例: 0.0〜999.9）
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'target_weight.required' => '目標の体重を入力してください',
            'target_weight.numeric'  => '4桁までの数字で入力してください',
            'target_weight.regex'    => '小数点は1桁で入力してください',
        ];
    }
}
