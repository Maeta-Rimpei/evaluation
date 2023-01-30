<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StaffUpdateRequest extends FormRequest
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
            'staff_code' => 'required', 'regex:/\A[a-zA-Z0-9]+\z/u', 'max:10', Rule::unique('staffs')->ignore($this->staff->id ?? null)->where(function ($user){
                return $user->whereNull('deleted');
            }),
            'name' => 'required', 'max:50', 'not_regex:/\A[a-zA-Z0-9]+\z\s/i', Rule::unique('staffs')->ignore($this->staff->id ?? null)->where(function ($user){
                return $user->whereNull('deleted');
            }),
            'role_id' => 'required|integer',
            'affiliation' => 'required|max:50',
        ];
    }

    public function attributes()
    {
        return [
            'staff_code' => '職員コード',
            'name' => '名前',
            'role_id' => '職位',
            'affiliation' => '職位',
        ];
    }

    public function messages()
    {
        return [
            'staff_code.required' => ':attributeの入力は必須です。',
            'staff_code.regex' => ':attributeは半角英数字で入力してください。',
            'staff_code.max' => ':attributeは10文字以内で設定してください。',
            'staff_code.unique' => 'その :attributeは既に登録されています。',
            'name.required' => ':attributeの入力は必須です。',
            'name.max' => ':attributeは50文字以内で入力してください。',
            'name.not_regex' => ':attributeは全角で入力してください。',
            'name.unique' => 'その :attributeは既に登録されています。',
            'role_id.required' => ':attributeが未入力です。管理者に問い合わせてください。',
            'role_id.integer' => ':attributeに不正な値が入力されました。管理者に問い合わせてください。',
            'affiliation.required' => ':attributeの入力は必須です。',
            'affiliation.max' => ':attributeは50文字以内で入力してください。',
        ];
    }
}
