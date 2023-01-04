<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvaRequest;
use App\Http\Requests\PasswordRequest;
use App\Models\Answer;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Catch_;

class EvaluationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * ホーム画面
     * @return view user.home
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $user_answers = $user->answers;

            return view('user.home', compact('user', 'user_answers'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 回答確認画面
     * @return view user.confirm_answer
     */
    public function confirmAnswers()
    {
        try {
            $user = \Auth::user();
            $user_answers = $user->answers;
            $user_questions = $user->questions;

            return view('user.confirm_answers', compact('user', 'user_answers', 'user_questions'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * フィードバック確認画面
     *@return view user.confirm_evaluation
     */
    public function confirmFeedback()
    {
        try {
            $user = \Auth::user();
            $user_total_evaluation = $user->total_evaluation;
            $user_evaluation = $user->evaluation;

            return view('user.confirm_feedback', compact('user', 'user_total_evaluation', 'user_evaluation'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * パスワード変更画面
     * @return view user.show_change_password
     */
    public function showChangePassword()
    {
        return view('show_change_password');
    }

    /**
     * パスワード変更実行
     * @param PasswordRequest $request
     *
     * @return view user.show_change_password
     */
    public function exeChangePassword(PasswordRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = \Auth::user();
            if (!password_verify($request->current_password, $user->password)) {
                return redirect()->route('showChangePassword')->with('alertDifferentPassword', 'パスワードが一致しません');
            }
            $new_password = $request->only(['password']);
            $user->password = bcrypt($new_password['password']);
            $user->save();
            DB::commit();

            return redirect()->route('showChangePassword')->with('successChangePassword', 'パスワードを変更しました');
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 回答フォーム
     * @return view user.evaluation_form
     */
    public function evaluationForm()
    {
        try {
            $user = \Auth::user();
            $user_questions = \Auth::user()->questions;

            return view('user.evaluation_form', compact('user', 'user_questions'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 回答データベース挿入実行
     * @param EvaRequest $request
     *
     * @return view evaluation_completed
     */
    public function evaluationStore(EvaRequest $request)
    {
        try {
            DB::beginTransaction();
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
                DB::commit();

                return redirect()->route('evaluationCompleted');
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 回答完了画面
     * @return view user.evaluation_completed
     */
    public function evaluationCompleted()
    {
        return view('user.completed');
    }
}
