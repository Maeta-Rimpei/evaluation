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
        $question = Question::find($question_id)->users->get();
        dd($question);
        $question->delete();

        $std_role = DB::table('questions')
            ->where('questions.id', '=', $question_id)
            ->select('question_user.role_id')
            ->join('question_user', 'questions.id', '=', 'question_user.question_id')
            ->first();

        // TODO:中間テーブルソフトデリート


        return redirect()->route('showDetailQuestionEdit', $std_role->role_id)
            ->with('deleteMessage', '削除しました。');
    }

    public function showCreateQuestion()
    {
        return view('admin.show_create_question');
    }

    // TODO:中間テーブル挿入
    public function exeCreateQuestion(Request $request)
    {
        $question = new Question();
        $inputs = $request->except(['role_id']);
        // dd($inputs);

        // $question->create($inputs);

        // $question->users()->attach($request->role_id);

        return redirect()->route('showCreateQuestion')->with('createQuestionMessage', '質問を作成しました。');
    }

    // TODO:何に対してのセキュリティ対策？？
    public static function escape($str)
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $str);
    }

    // TODO:最低限の検索OK　キーワードが空の時の処理検討
    // TODO:Viewでの見せ方→ 現状：未入力の時全部取ってくる
    public function searchQuestion(Request $request)
    {
        $keyword = $request->input('keyword');
        $category = $request->input('category');
        $role_id = $request->input('role_id');
        // dd($role_id);
        $query = Question::query();
        $p = $query->join('question_user', 'questions.id', '=', 'question_user.question_id')
            ->select(
                'questions.id',
                'questions.content',
                'questions.category',
                'question_user.role_id'
            );

        if (isset($keyword))
            $query->when($request, function ($query, $request) {
                $query->where('content', 'LIKE', '%' . self::escape($request->keyword) . '%');
            });

        if (isset($category)) {
            $query->when($request, function ($query, $request) {
                return $query->where('category', '=', $request->category);
            });
        }

        if (isset($role_id)) {
            $query->when($request, function ($query, $request) {
                return $query->where('role_id', '=', $request->role_id);
            });
        }

        $search_questions = $query->orderBy('questions.content', 'desc')->paginate(10);
        // dd($search_questions);
        // $q = $search_questions->all();
        // ddd($q);
        return view('admin.show_search_question', compact('keyword', 'category', 'role_id', 'search_questions'));
    }

    /**
     * 職員検索
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function searchStaff(Request $request)
    {
        $name = $request->input('name');
        $staff_id = $request->input('staff_id');
        $affiliation = $request->input('affiliation');
        $role_id = $request->input('role_id');

        $user_affiliations = User::get('affiliation');

        $query = User::query();

        if (isset($name)) {
            $space_conversion = mb_convert_kana($name, 's');
            // TODO:/[\s,]+/ ←この表現の意味は？
            $name_push_array = preg_split('/[\s,]+/', $space_conversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach ($name_push_array as $word) {
                $query->where('name', 'LIKE', '%' . self::escape($word) . '%');
            }
        }

        if (isset($staff_id)) {
            $query->when($request, function ($query, $request) {
                return $query->where('staff_id', '=', $request->staff_id);
            });
        }

        if (isset($affiliation)) {
            $query->when($request, function ($query, $request) {
                return $query->where('affiliation', '=', $request->affiliation);
            });
        }

        if (isset($request->role_id)) {
            $query->when($request, function ($query, $request) {
                return $query->where('role_id', '=', $request->role_id);
            });
        }

        $search_staffs = $query->orderBy('users.created_at', 'desc')->paginate(10);
        // dd($search_questions);
        $q = $search_staffs->all();
        // ddd($q);
        return view('admin.search_staff', compact('name', 'staff_id', 'affiliation', 'user_affiliations', 'role_id', 'search_staffs'));
    }
}