<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeightLogStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date'             => ['required', 'date'],
            'weight'           => ['required', 'numeric', 'between:0,999.9', 'regex:/^\d{1,3}(\.\d)?$/'],
            'calories'         => ['required', 'integer'],
            'exercise_time'    => ['required', 'date_format:H:i'],
            'exercise_content' => ['nullable', 'max:120'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.required'          => '日付を入力してください',
            'weight.required'        => '体重を入力してください',
            'weight.numeric'         => '数字で入力してください',
            'weight.between'         => '4桁までの数字で入力してください',
            'weight.regex'           => '小数点は1桁で入力してください',
            'calories.required'      => '摂取カロリーを入力してください',
            'calories.integer'       => '数字で入力してください',
            'exercise_time.required' => '運動時間を入力してください',
            'exercise_content.max'   => '120文字以内で入力してください',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(
            function ($v) {
                $weight = $this->input('weight');

                if ($weight !== null && $weight !== '') {
                    // 数字と小数点のみかを先にチェック
                    if (!preg_match('/^\d+(\.\d+)?$/', (string)$weight)) {
                       
                        return;
                    }
                    $parts = explode('.', (string)$weight);
                    $intDigits = strlen(ltrim($parts[0], '0')) ?: 1; // "0"の扱い
                    if ($intDigits > 4) {
                        $v->errors()->add('weight', '4桁までの数字で入力してください');
                    }

                    // 小数部（1桁まで）
                    if (isset($parts[1]) && strlen($parts[1]) > 1) {
                        $v->errors()->add('weight', '小数点は1桁で入力してください');
                    }
                }
            }
        );
    }
}
