<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffCreateRequest extends FormRequest
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
            'staff_code' => 'required|regex:/\A[a-zA-Z0-9]+\z/u|max:10',
            'name' => 'required|max:50|not_regex:/\A[a-zA-Z0-9]+\z/i',
            'role_id' => 'required|integer',
            'affiliation' => 'required|max:50',
            'password' => 'required|string|regex:/\A([a-zA-Z0-9]{8,})+\z/u|confirmed',
            'password_confirmation' => 'regex:/\A([a-zA-Z0-9]{8,})+\z/u',
        ];
    }

    public function attributes()
    {
        return [
            'staff_code' => '職員コード',
            'name' => '名前',
            'role_id' => '職位',
            'affiliation' => '職位',
            'password' => 'パスワード',
            'password_confirmation' => 'パスワード(確認)',
        ];
    }

    public function messages()
    {
        return [
            'staff_code.required' => ':attributeの入力は必須です。',
            'staff_code.regex' => ':attributeは半角英数字で入力してください。',
            'staff_code.max' => ':attributeは10文字以内で設定してください。',
            'name.required' => ':attributeの入力は必須です。',
            'name.max' => ':attributeは50文字以内で入力してください。',
            'name.not_regex' => ':attributeは全角で入力してください。',
            'role_id.required' => ':attributeが未入力です。管理者に問い合わせてください。',
            'role_id.integer' => ':attributeに不正な値が入力されました。管理者に問い合わせてください。',
            'affiliation.required' => ':attributeの入力は必須です。',
            'affiliation.max' => ':attributeは50文字以内で入力してください。',
            'password.required' => ':attributeの入力は必須です。',
            'password.regex' => ':attributeは半角英数字8文字以上で入力してください。',
            'password.confirmed' => ':attributeが不一致です。',
            'password_confirmation.regex' => ':attributeは半角英数字8文字以上で入力してください。'
        ];
    }
}
