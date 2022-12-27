<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Admin;
use App\Models\User;
use App\Models\Answer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\AnswerRequest;
use App\Http\Requests\QuestionCreateRequest;
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
        try {
            $credentials = $request->only('staff_id', 'password');

            if (\Auth::guard('admin')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect('admin/index');
            }

            return back()->withErrors([
                'login_error' => '職員コードかパスワードが間違っています。',
            ]);

        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    public function logout(Request $request)
    {
        try {
            \Auth::guard('admin')->logout();
            $request->session()->invalidate(); // セッションの削除
            $request->session()->regenerateToken(); // セッションの再生成（_token）
            return redirect('admin/login');
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    // --------------------管理者画面操作関係----------------------
    public function showStaff()
    {
        try {
            $users = User::get();
            return view('admin.staff', compact('users'));

        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }

    }

    public function showStaffDetail($id)
    {
        try {
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
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    public function evaluationStaff($id)
    {
        try {
            $user = User::find($id);
            return view('admin.evaluation_staff', compact('user'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }

    }

    public function exeEvaluationStaff($id, Request $request)
    {
        try {
            DB::beginTransaction();
            $user = User::find($id);
            $evaluation = $request->only(['evaluation']);
            $user->save();
            DB::commit();
            return redirect()->route('evaluationStaff', $user->id)->with('evaluationMessage', 'フィードバックコメントを編集しました。');
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error($e);
            throw $e;
        }
    }

    public function exeEditEvaluationStaff($id, Request $request)
    {
        try {
            $user = User::find($id);
            $evaluation = $request->only(['evaluation']);
            $user->update($evaluation);
            return redirect()->route('evaluationStaff', $user->id)->with('evaluationUpdateMessage', 'フィードバックコメントを編集しました。');
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

    public function showStaffSoftDeleted()
    {
        $users = User::get()->all();

        return view('admin.show_deleted_staff', compact('users'));
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

    public function showDetailQuestionEdit($role)
    {
        $questions = DB::table('questions')
            ->where('question_user.role_id', "=", $role)
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

    public function exeQuestionDestroyed($question_id)
    {
        $std_role = DB::table('questions')
            ->where('questions.id', '=', $question_id)
            ->select('question_user.role_id')
            ->join('question_user', 'questions.id', '=', 'question_user.question_id')
            ->first();

        // 中間テーブルを削除→onDeleteCascadeによりリレーション先のquestionsレコードも削除
        $question = Question::find($question_id);
        $question->users()->detach();

        return redirect()->route('showDetailQuestionEdit', $std_role->role_id)
            ->with('deleteMessage', '削除しました。');
    }

    public function showCreateQuestion()
    {
        return view('admin.show_create_question');
    }

    public function exeCreateQuestion(QuestionCreateRequest $request)
    {
        $question = new Question();
        $inputs = $request->only(['content', 'category', 'role_id']);

        $question->create([
            'content' => $inputs['content'],
            'category' => $inputs['category'],
        ]);

        // 184～187行目で挿入したquestionのidを取得
        $question_id = $question->latest('id')->first()->id;
        $new = $question->find($question_id);
        // 中間テーブルに挿入
        $new->users()->attach($inputs['role_id']);

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
        $query->join('question_user', 'questions.id', '=', 'question_user.question_id')
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
        $role_id = $request->input('role');

        $affiliations = User::get('affiliation')->toArray();
        $user_affiliations = array_column($affiliations, 'affiliation');
        // dd($affiliations);

        // dd($user_affiliations);
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
            $staff_id_push_array = preg_split('/[\s,]+/', $staff_id, -1, PREG_SPLIT_NO_EMPTY);

            foreach ($staff_id_push_array as $word) {
                $query->where('staff_id', 'LIKE', '%' . self::escape($staff_id) . '%');
            }
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

        return view('admin.search_staff', compact('name', 'staff_id', 'affiliation', 'user_affiliations', 'role_id', 'search_staffs'));
    }

    public function showAdminSoftDeleted()
    {
        $admins = Admin::get();

        return view('admin.show_deleted_admin', compact('admins'));
    }

    public function exeAdminSoftDeleted($id)
    {
        $admin = Admin::find($id);
        $admin->delete();

        return redirect()->route('showAdminSoftDeleted')->with('deleteMessage', '削除しました。');
    }

    public function showAdmin()
    {
        $admins = Admin::get();

        return view('admin.admin', compact('admins'));
    }

    public function searchAdmin(Request $request)
    {
        $name = $request->input('name');
        $staff_id = $request->input('staff_id');
        $affiliation = $request->input('affiliation');
        $role_id = $request->input('role');

        $admin_affiliations = Admin::get('affiliation');

        $query = Admin::query();

        if (isset($name)) {
            $space_conversion = mb_convert_kana($name, 's');
            // TODO:/[\s,]+/ ←この表現の意味は？
            $name_push_array = preg_split('/[\s,]+/', $space_conversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach ($name_push_array as $word) {
                $query->where('name', 'LIKE', '%' . self::escape($word) . '%');
            }
        }

        if (isset($staff_id)) {
            $staff_id_push_array = preg_split('/[\s,]+/', $staff_id, -1, PREG_SPLIT_NO_EMPTY);

            foreach ($staff_id_push_array as $word) {
                $query->where('staff_id', 'LIKE', '%' . self::escape($staff_id) . '%');
            }
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

        $search_admins = $query->orderBy('admins.created_at', 'desc')->paginate(10);

        return view('admin.search_admin', compact('name', 'staff_id', 'affiliation', 'admin_affiliations', 'role_id', 'search_admins'));
    }

    public function showEditAnswer()
    {
        $users = User::get();

        return view('admin.show_edit_answer', compact('users'));
    }

    public function exeAllDeletedAnswer($id)
    {
        $user_answer = Answer::where('user_id', '=', $id);

        if (!empty($user_answer)) {
            return redirect()->route('showEditAnswer')->with('errorAnswerEmptyMessage', 'この方はまだ回答していません。');
        }
        // dd($user_answer);
        $user_answer->delete();

        return redirect()->route('showEditAnswer')->with('allDeleteAnswerMessage', '回答を全て削除しました。');
    }

    public function showPartEditAnswer($id)
    {
        $user = User::find($id);

        $user_questions_answers = DB::table('users')
            ->where('answers.user_id', '=', $id)
            ->select(
                'users.id as user_id',
                'questions.id as question_id',
                'questions.content',
                'questions.category',
                'answers.id as answer_id',
                'answers.answer',
            )
            ->leftJoin('answers', 'users.id', '=', 'answers.user_id')
            ->leftJoin('questions', 'questions.id', '=', 'answers.question_id')
            ->get()->toArray();

        $array_user_questions_answers = json_decode(json_encode($user_questions_answers), true);

        return view('admin.show_part_edit_answer', compact('user', 'array_user_questions_answers'));
    }

    public function exePartDeletedAnswer($answer_id)
    {
        $user_answer = Answer::find($answer_id);
        $user_answer->destroy($answer_id);

        return redirect()->route('showPartEditAnswer')->with('partDeleteAnswerMessage', '選択した回答を削除しました。');
    }

    public function showUpdatedAnswer($answer_id)
    {
        $user_answer = Answer::find($answer_id);

        return view('admin.show_updated_answer', compact('user_answer'));
    }

    public function exeUpdatedAnswer($answer_id, AnswerRequest $request)
    {
        $answer = $request->only(['answer']);
        $user_answer = Answer::find($answer_id);
        $user_id = Answer::find($answer_id)->user->id;

        $user_answer->update($answer);

        return redirect()->route('showPartEditAnswer', $user_id)->with('updateAnswerMessage', '回答を修正しました。');
    }
}