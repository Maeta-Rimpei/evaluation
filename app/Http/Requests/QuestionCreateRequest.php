<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionCreateRequest extends FormRequest
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
            'content' => 'required',
            'category' => 'required|integer',
            'role_id' => 'required|integer',
        ];
    }

    public function attributes()
    {
        return [
            'content' => '質問内容',
            'category' => 'カテゴリー',
            'role_id' => '対象職員',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => ':attributeの入力は必須です。',
            'category.required' => ':attributeが未入力です。管理者に問い合わせてください。',
            'category.integer' => ':attributeに不正な文字が入力されました。管理者に問い合わせてください。',
            'role_id.required' => ':attributeが未入力です。管理者に問い合わせてください。',
            'role_id.integer' => ':attributeに不正な文字が入力されました。管理者に問い合わせてください。',
        ];
    }
}
