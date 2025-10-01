<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterStep2Request extends FormRequest
{
    protected $errorBag = 'registerStep2';
    public function authorize(): bool
    {
        return true; // 認証後の画面なので OK
    }

    public function rules(): array
    {

        $oneDecimalRegex = '/^\d{1,4}(\.\d{1})?$/';

        return [
            'current_weight' => ['required', 'numeric', 'max:9999.9', "regex:$oneDecimalRegex"],
            'target_weight'  => ['required', 'numeric', 'max:9999.9', "regex:$oneDecimalRegex"],
        ];
    }

    public function messages(): array
    {
        return [
            // 現在の体重
            'current_weight.required' => '現在の体重を入力してください',
            'current_weight.max'   => '4桁までの数字で入力してください',
            'current_weight.regex'    => '小数点は1桁で入力してください',

            // 目標の体重
            'target_weight.required' => '目標の体重を入力してください',
            'target_weight.max'  => '4桁までの数字で入力してください',
            'target_weight.regex'    => '小数点は1桁で入力してください',
        ];
    }
}
