<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'staff_code' => 'required',
            'password' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'staff_code' => '職員コード',
            'password' => 'パスワード'
        ];
    }

    public function messages()
    {
        return [
            'staff_code.required' => ':attributeの入力は必須です。',
            'password.required' => ':attributeの入力は必須です。',
        ];
    }
}
