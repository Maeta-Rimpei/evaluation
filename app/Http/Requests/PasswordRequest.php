<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'current_password' => 'required|regex:/\A([a-zA-Z0-9]{8,})+\z/u',
            'password' => 'required|regex:/\A([a-zA-Z0-9]{8,})+\z/u|confirmed',
            'password_confirmation' => 'required|regex:/\A([a-zA-Z0-9]{8,})+\z/u',
        ];
    }

    public function attributes()
    {
        return [
            'current_password' => '現在のパスワード',
            'password' => '新しいパスワード',
            'password_confirmation' => '新しいパスワード(確認)',
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => ':attributeの入力は必須です。',
            'current_password.regex' => ':attributeは半角英数字8文字以上で入力してください',
            'password.required' => ':attributeの入力は必須です。',
            'password.regex' => ':attributeは半角英数字8文字以上で入力してください',
            'password.confirmed' => ':attributeと:attribute(確認)が不一致です。',
            'password_confirmation.required' => ':attributeの入力は必須です。',
            'password_confirmation.regex' => ':attributeは半角英数字8文字以上で入力してください',
        ];
    }
}
