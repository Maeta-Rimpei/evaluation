<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            ->join('question_user', 'users.role_id', '=', 'question_user.role_id')
            ->join('questions', 'questions.id', '=', 'question_user.question_id')
            ->join('answers', 'questions.id', '=', 'answers.question_id')
            ->get();

        $option_qs = [];
        $desc_qs_as = [];

        foreach ($user_questions_answers as $user_question_answer) {
            if ($user_question_answer->category == 0) {
                array_push($option_qs, $user_question_answer->answer);
            } else {
                $desc_qs_as[$user_question_answer->content] = $user_question_answer->answer;
            }
        }
        
        $count_option_qs = array_count_values($option_qs);
        return view('admin.staff_detail', compact('user', 'user_questions_answers', 'count_option_qs', 'desc_qs_as'));
    }
}