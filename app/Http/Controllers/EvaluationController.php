<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvaRequest;
use App\Http\Requests\PasswordRequest;
use App\Models\Answer;
use App\Models\Staff;
use GrahamCampbell\ResultType\Success;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Catch_;

class EvaluationController extends Controller
{
    private $staff;
    private $answer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->staff = new Staff();
        $this->answer = new Answer();
    }

    /**
     * ホーム画面
     * @return view user.home
     */
    public function index()
    {
        try {
            $user = $this->staff->getAuthUser();
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
            $user = $this->staff->getAuthUser();
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
            $user = $this->staff->getAuthUser();
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
            $user =  $this->staff->getAuthUser();
            if (!password_verify($request->current_password, $user->password)) {
                return redirect()->route('showChangePassword')->with('alertDifferentPassword', 'パスワードが一致しません');
            }

            $new_password = $request->only(['password']);
            $user->password = bcrypt($new_password['password']);
            $this->staff->saveStaff();
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
            $user = $this->staff->getAuthUser();
            $user_questions = $user->questions;

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
            $auth_user = $this->staff->getAuthUser();
            $auth_user_questions = $auth_user->questions;       
            $count = $this->staff->countAuthUserQuestions($auth_user_questions);
            
            for ($i = 0; $i < $count; $i++) {
                // question_idとstaff_idを$requestに追加
                $request->merge([
                    'question_id' => $auth_user_questions[$i]->id,
                    'staff_id' => $auth_user->id
                ]);
                
                $inputs = $request->only(['question_id', 'staff_id', 'answer']);

                // DB挿入
                $answer = new Answer();
                $answer->question_id = $inputs['question_id'];
                $answer->staff_id = $inputs['staff_id'];
                $answer->answer = $inputs['answer'][$i];
                $answer->saveAnswer();
                DB::commit();
            }
            // dd($inputs['question_id']);

            return redirect()->route('evaluationCompleted');
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
