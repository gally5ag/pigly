<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeightLogUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date'              => ['required', 'date'],
            'weight'            => ['required', 'numeric'],          // 体重は数値入力（小数1桁・4桁までの詳細は後段）
            'calories'          => ['required', 'integer'],
            'exercise_time'     => ['required', 'date_format:H:i'],  // 00:00 形式
            'exercise_content'  => ['nullable', 'string', 'max:120'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.required'              => '日付を入力してください',
            'weight.required'            => '体重を入力してください',
            'weight.numeric'             => '数字で入力してください',
            'calories.required'          => '摂取カロリーを入力してください',
            'calories.integer'           => '数字で入力してください',
            'exercise_time.required'     => '運動時間を入力してください',
            'exercise_time.date_format'  => '00:00 の形式で入力してください',
            'exercise_content.max'       => '120文字以内で入力してください',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($v) {
            $weight = $this->input('weight');
            if ($weight === null || $weight === '') return;

            if (!preg_match('/^\d+(\.\d+)?$/', (string)$weight)) return; // numeric と重複しないよう予備

            $parts = explode('.', (string)$weight);
            $intDigits = strlen(ltrim($parts[0], '0')) ?: 1;
            if ($intDigits > 4) {
                $v->errors()->add('weight', '4桁までの数字で入力してください');
            }
            if (isset($parts[1]) && strlen($parts[1]) > 1) {
                $v->errors()->add('weight', '小数点は1桁で入力してください');
            }
        });
    }
}
