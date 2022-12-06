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

        return view('admin.staff_detail', compact('user', 'array_user_questions_answers', 'answers_count'));
    }

    public function showStaffSoftDeleted()
    {
        $users = User::get()->all();

        return view('admin.show_staff_deleted', compact('users'));
    }

    public function exeStaffSoftDeleted($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('showStaffSoftDeleted')->with('deleteMessage', '削除しました。');
    }

    public function showQuestionEdit()
    {
        return view('admin.show_question_edit');
    }

    public function showDetailQuestionEdit($role_id)
    {
        $questions = DB::table('questions')
            ->where('question_user.role_id', "=", $role_id)
            ->whereNull('questions.deleted_at')
            ->select(
                'questions.id as question_id',
                'questions.content',
                'questions.category',
                'question_user.role_id'
            )
            ->leftJoin('question_user', 'questions.id', '=', 'question_id')
            ->get();

        return view('admin.show_detail_edit', compact('questions'));
    }

    public function editForm($question_id)
    {
        $question = DB::table('questions')
            ->where('question_user.question_id', "=", $question_id)
            ->select(
                'questions.id as question_id',
                'questions.content',
                'questions.category',
                'question_user.role_id',
            )
            ->leftJoin('question_user', 'questions.id', '=', 'question_id')
            ->first();
        // dd($question);

        return view('admin.edit_form', compact('question'));
    }

    public function editExe(Request $request, $question_id)
    {
        $std_role = DB::table('questions')
            ->where('questions.id', '=', $question_id)
            ->select('question_user.role_id')
            ->join('question_user', 'questions.id', '=', 'question_user.question_id')
            ->first();

        $question = Question::find($question_id);

        $question->content = $request->content;
        $question->category = $request->category;
        $question->save();

        return redirect()->route('showDetailQuestionEdit', $std_role->role_id)->with('editMessage', '質問内容を更新しました。');
    }

    public function exeQuestionSoftDeleted($question_id)
    {
        $std_role = DB::table('questions')
            ->where('questions.id', '=', $question_id)
            ->select('question_user.role_id')
            ->join('question_user', 'questions.id', '=', 'question_user.question_id')
            ->first();

            // TODO:中間テーブルソフトデリート
        // DB::table('question_user')
        // ->where('question_user.question_id', '=', $question_id)
        // ->where('question_user.role_id', '=', $std_role->role_id)


        $question = Question::find($question_id);
        $question->delete();

        return redirect()->route('showDetailQuestionEdit', $std_role->role_id)
            ->with('deleteMessage', '削除しました。');
    }

    public function showCreateQuestion()
    {
        return view('admin.show_create_question');
    }

    public function exeCreateQuestion(Request $request)
    {
        $inputs = $request->only(['content', 'category']);
        Question::create($inputs);

        // dd($inputs);
        $question->users()->syncWithoutDetaching($request->role_id);

        $question->users()->syncWithoutDetaching($question->id);
        $question->save();

        return redirect()->route('showCreateQuestion')->with('createQuestionMessage', '質問を作成しました。');
    }
}
