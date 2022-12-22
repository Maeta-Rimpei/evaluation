<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvaRequest;
use App\Http\Requests\PasswordRequest;
use App\Models\Answer;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    public function index()
    {
        try {
            \Auth::checkExistAuthUser();
            $user_answers = \Auth::user()->answers;
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }

        return view('home', compact('user', 'user_answers'));
    }

    public function confirmAnswers()
    {
        try {
             
            $user = \Auth::user();
            $user_answers = $user->answers;
            $user_questions = $user->questions;
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }

        return view('confirm_answers', compact('user', 'user_answers', 'user_questions'));
    }

    public function confirmFeedback()
    {
        try {
             
            $user = \Auth::user();
            $user_total_evaluation = $user->total_evaluation;
            $user_evaluation = $user->evaluation;

        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }

        return view('confirm_feedback', compact('user', 'user_total_evaluation', 'user_evaluation'));
    }

    public function showChangePassword()
    {
        return view('show_change_password');
    }

    public function exeChangePassword(PasswordRequest $request)
    {
        
        $user = \Auth::user();
        if (!password_verify($request->current_password, $user->password)) {
            return redirect()->route('showChangePassword')->with('alertDifferentPassword', 'パスワードが一致しません');
        }

        $new_password = $request->only(['password']);
        $user->password = bcrypt($new_password['password']);
        $user->save();

        return redirect()->route('showChangePassword')->with('successChangePassword', 'パスワードを変更しました');
    }

    public function evaluationForm()
    {
        try {
            \Auth::checkExistAuthUser();
            $auth_user_questions = \Auth::user()->questions;

        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }

        return view('evaluation_form', compact('auth_user_questions'));
    }

    public function evaluationStore(Request $request)
    {
        
        $auth_user = \Auth::user();
        $auth_user_questions = $auth_user->questions;
        $count = count($auth_user_questions);

        for ($i = 0; $i < $count; $i++) {
            // question_idとuser_idを$requestに追加
            $request->merge([
                'question_id' => $auth_user_questions[$i]->id,
                'user_id' => $auth_user->id
            ]);
            $data = $request->only(['answer', 'question_id', 'user_id']); //$request->all() ----> $request->answer[$i]  変更
            // DB挿入
            $answer = new Answer;
            $answer->question_id = $data['question_id'];
            $answer->user_id = $data['user_id'];
            $answer->answer = $data['answer'][$i];
            $answer->save();
        }

        return redirect()->route('evaluationCompleted');
    }

    public function evaluationCompleted()
    {
        return view('completed');
    }
}