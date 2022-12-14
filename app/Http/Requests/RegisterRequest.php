<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'staff_id' => 'required',
            'name' => 'required',
            'role_id' => 'required|integer',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'min:6',
        ];
    }

    public function attributes()
    {
        return [
            'stafF_id' => '職員コード',
            'name' => '名前',
            'role_id' => '職位',
            'password' => 'パスワード',
            'password_confirmation' => 'パスワード(確認)',
        ];
    }
}
