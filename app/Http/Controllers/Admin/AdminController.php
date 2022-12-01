<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Consts\AnswerOptionConsts;

class AdminController extends Controller
{
    // --------------------認証関係----------------------
    public function index()
    {
        return view('admin.index');
    }

    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('staff_id', 'password');

        if (\Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('admin/index');
        }

        return back()->withErrors([
            'login_error' => '職員コードかパスワードが間違っています。',
        ]);
    }

    public function logout(Request $request)
    {
        \Auth::guard('admin')->logout();
        $request->session()->invalidate(); // セッションの削除
        $request->session()->regenerateToken(); // セッションの再生成（_token）
        return redirect('admin/login');
    }

    // --------------------管理者画面操作関係----------------------

    public function showStaff()
    {
        $users = User::get()->all();

        return view('admin.staff', compact('users'));
    }

    public function showStaffDetail($id)
    {
        $user = User::find($id);

        $user_questions_answers = DB::table('users')
        ->where('users.id', '=', $id)
        ->where('answers.user_id', '=', $id)
        ->select(
        'users.id as user_id',
        'questions.id as question_id',
        'questions.content',
        'questions.category',
        'answers.answer',
        )
        ->leftjoin('answers', 'users.id', '=', 'answers.user_id')
        ->leftJoin('questions', 'questions.id', '=', 'answers.question_id')
        ->get();

        // $user_questions_answersをstdClassから配列化
        $array_user_questions_answers = json_decode(json_encode($user_questions_answers), true);
        // 解答を集計
        $answers_count = array_count_values(array_column($array_user_questions_answers, 'answer'));

        return view('admin.staff_detail',compact('user', 'array_user_questions_answers', 'answers_count'));
    }
}