<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;
use App\Models\User;

class EvaRequest extends FormRequest
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
        $count_questions = count(Auth::user()->questions);

        return [
            'answer[]' => "array|size:$count_questions",
            'answer.*' => 'required|string',

        ];
    }

    public function messages()
    {
        return [
            'answer[].required' => '全ての問に回答してください',
            'answer[].array' => '不正なデータ形式です。管理者に問い合わせてください。',
            'answer[].size' => '全ての問に回答してください',
            'answer.*.required' => '全ての問に回答してください',
            'answer.*.string' => '文字で回答してください',
        ];
    }
}
