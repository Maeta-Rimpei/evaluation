<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\AnswerRequest;
use App\Http\Requests\QuestionCreateRequest;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private $admin;
    private $user;
    private $question;
    private $answer;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->admin = new Admin();
        $this->user = new User();
        $this->question = new Question();
        $this->answer = new Answer();
    }

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
            $users = $this->user->getAllUsers();
            return view('admin.staff', compact('users'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    public function showStaffDetail($id)
    {
        try {
            $user = $this->user->getUser($id);
            $user_questions_answers = getQuestionsAndAnswers($id);

            // $user_questions_answersをstdClassから配列化
            $array_user_questions_answers = $this->user->conversionToArray($user_questions_answers);
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
            $user = $user = $this->user->getUser($id);
            $evaluation = $request->only(['evaluation']);
            $user->save();
            DB::commit();
            return redirect()->route('evaluationStaff', $user->id)->with('evaluationMessage', 'フィードバックコメントを送信しました。');
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error($e);
            throw $e;
        }
    }

    public function exeEditEvaluationStaff($id, Request $request)
    {
        try {
            $user = $user = $this->user->getUser($id);
            $evaluation = $request->only(['evaluation']);
            $user->update($evaluation);
            return redirect()->route('evaluationStaff', $user->id)->with('evaluationUpdateMessage', 'フィードバックコメントを編集しました。');
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

    public function showStaffSoftDeleted()
    {
        try {
            $users = $this->user->getAllUsers();
            return view('admin.show_deleted_staff', compact('users'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    public function exeStaffSoftDeleted($id)
    {
        try {
            $user = $this->user->getUserOrFail($id);
            $user->delete();
            return redirect()->route('showStaffSoftDeleted')->with('deleteMessage', '削除しました。');
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    public function showQuestionEdit()
    {
        return view('admin.show_question_edit');
    }

    public function showDetailQuestionEdit($role_id)
    {
        $questions = $this->question->getQuestionsByRoleId($role_id);
        try {
            $questions = $this->question->getQuestionsByRoleId($role_id);

            return view('admin.show_detail_edit', compact('questions'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    public function editForm($question_id)
    {
        $question = $this->question->getQuestionByQuestionId($question_id);
        try {
            $question = $this->question->getQuestionByQuestionId($question_id);

            return view('admin.edit_form', compact('question'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    public function editExe(Request $request, $question_id)
    {
        $std_role = $this->question->getRoleIdByQuestionId($question_id);
        try {
            $std_role = $this->question->getRoleIdByQuestionId($question_id);
            $question = Question::findOrFail($question_id);

            $question->content = $request->content;
            $question->category = $request->category;
            $question->save();

            return redirect()->route('showDetailQuestionEdit', $std_role->role_id)->with('editMessage', '質問内容を更新しました。');
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error($e);
            throw $e;
        }
    }

    public function exeQuestionDestroyed($question_id)
    {
        try {
            $std_role = $this->question->getRoleIdByQuestionId($question_id);
        // 中間テーブルを削除→onDeleteCascadeによりリレーション先のquestionsレコードも削除
        $question = Question::find($question_id);
        $question->users()->detach();

            return redirect()->route('showDetailQuestionEdit', $std_role->role_id)
                ->with('deleteMessage', '削除しました。');
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    public function showCreateQuestion()
    {
        return view('admin.show_create_question');
    }

    public function exeCreateQuestion(QuestionCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $question = new Question();
            $inputs = $request->only(['content', 'category', 'role_id']);

            $question->create([
                'content' => $inputs['content'],
                'category' => $inputs['category'],
            ]);

            // 184～187行目で挿入したquestionのidを取得
            $question_id = $question->latest('id')->first()->id;
            $new = $question->findOrFail($question_id);
            // 中間テーブルに挿入
            $new->users()->attach($inputs['role_id']);
            DB::commit();
            return redirect()->route('showCreateQuestion')->with('createQuestionMessage', '質問を作成しました。');
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error($e);
            throw $e;
        }
    }

    // TODO:何に対してのセキュリティ対策？？
    public static function escape($str)
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $str);
    }

    public function searchQuestion(Request $request)
    {
        try {
            $keyword = $request->input('keyword');
            $category = $request->input('category');
            $role_id = $request->input('role_id');

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
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 職員検索
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function searchStaff(Request $request)
    {
        try {
            $name = $request->input('name');
            $staff_id = $request->input('staff_id');
            $affiliation = $request->input('affiliation');
            $role_id = $request->input('role');

            $affiliations = User::get('affiliation')->toArray();
        $user_affiliations = array_column($affiliations, 'affiliation');
        // dd($affiliations);

        $query = User::query();

            if (isset($name)) {
                $space_conversion = mb_convert_kana($name, 's');
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
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    public function showAdminSoftDeleted()
    {
        try {
            $admins = Admin::get();

            return view('admin.show_deleted_admin', compact('admins'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    public function exeAdminSoftDeleted($id)
    {
        try {
            $admin = Admin::findOrFail($id);
            $admin->delete();

            return redirect()->route('showAdminSoftDeleted')->with('deleteMessage', '削除しました。');
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    public function showAdmin()
    {
        try {

            $admins = Admin::get();

            return view('admin.admin', compact('admins'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    public function searchAdmin(Request $request)
    {
        try {
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
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    public function showEditAnswer()
    {
        try {
            $users = $this->user->getAllUsers();

            return view('admin.show_edit_answer', compact('users'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    public function exeAllDeletedAnswer($id)
    {
        try {
            $user_answer = Answer::where('user_id', '=', $id);

            if (!empty($user_answer)) {
                return redirect()->route('showEditAnswer')->with('errorAnswerEmptyMessage', 'この方はまだ回答していません。');
            }

            $user_answer->delete();

            return redirect()->route('showEditAnswer')->with('allDeleteAnswerMessage', '回答を全て削除しました。');
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    public function showPartEditAnswer($id)
    {
        try {
            $user = $this->user->getUser($id);
            $user_questions_answers = $this->user->getQuestionsAndAnswers($id);
            $array_user_questions_answers = $this->user->conversionToArray($user_questions_answers);

            return view('admin.show_part_edit_answer', compact('user', 'array_user_questions_answers'));
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    public function exePartDeletedAnswer($answer_id)
    {
        try {
            $user_answer = Answer::findOrFail($answer_id);
            $user_answer->destroy($answer_id);

            return redirect()->route('showPartEditAnswer')->with('partDeleteAnswerMessage', '選択した回答を削除しました。');
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    public function showUpdatedAnswer($answer_id)
    {
        try {
            $user_answer = Answer::findOrFail($answer_id);

            return view('admin.show_updated_answer', compact('user_answer'));
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    public function exeUpdatedAnswer($answer_id, AnswerRequest $request)
    {
        try {
            $answer = $request->only(['answer']);
            $user_answer = Answer::findOrFail($answer_id);
            $user_id = Answer::findOrFail($answer_id)->user->id;

            $user_answer->update($answer);

            return redirect()->route('showPartEditAnswer', $user_id)->with('updateAnswerMessage', '回答を修正しました。');
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }
}
