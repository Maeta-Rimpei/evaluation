<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvaRequest;
use App\Models\Answer;
use App\Models\Role;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use App\Models;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class EvaluationController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function evaluationForm()
    {
        $auth_user = \Auth::user();
        $auth_user_questions = $auth_user->questions;

        return view('evaluation_form', compact('auth_user', 'auth_user_questions'));
    }

    public function evaluationStore(EvaRequest $request)
    {
        // バリデーションできてないよ！！
        $auth_user = \Auth::user();
        $auth_user_questions = $auth_user->questions;
        $count = count($auth_user_questions);

        for ($i=0; $i<$count; $i++) {
            // 受け取ったanswerの分だけquestion_idとuser_idを$requestに追加
            $request->merge([
                'question_id' => $auth_user_questions[$i]->id,
                'user_id' => $auth_user->id
            ]);
            $data = $request->all();
            // DB挿入
            $answer = new Answer;
            $answer->question_id = $data['question_id'];
            $answer->user_id = $data['user_id'];
            $answer->answer = $data['answer'][$i];
            $answer->save();
        }
        return redirect(route('evaluationCompleted'));
    }

    public function evaluationCompleted()
    {
        return view('completed');
    }
}