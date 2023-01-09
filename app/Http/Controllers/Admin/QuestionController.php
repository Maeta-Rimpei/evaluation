<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\QuestionEditRequest;
use App\Http\Requests\QuestionCreateRequest;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    private $question;
    /**
     * Summary of __construct
     * @return void
     */
    public function __construct()
    {
        $this->question = new Question();
    }

    /**
     * 質問作成画面
     * @return view Admin.question.questionshow_create_question
     */
    public function showCreateQuestion()
    {
        return view('Admin.question.show_create_question');
    }

    /**
     * 質問作成
     * @param QuestionCreateRequest $request
     *
     * @return view Admin.question.show_create_question
     * */
    public function exeCreateQuestion(QuestionCreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $inputs = $request->only(['content', 'category', 'role_id']);

            // questionsテーブルに挿入
            $this->question->create([
                'content' => $inputs['content'],
                'category' => $inputs['category'],
            ]);

            // ↑で挿入したquestionのidを取得
            $question_id = $this->question->getLastQuestionId();
            $newQuestion = $this->question->getQuestion($question_id);
            // 中間テーブルに挿入
            $newQuestion->insertPivotTable($inputs['role_id']);
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

    /**
     * 質問区分一覧画面
     * @return view Admin.question.show_edit_question
     */
    public function showEditQuestion()
    {
        return view('Admin.question.show_edit_question');
    }

    /**
     * 区分ごとの質問詳細画面
     * @param int $role_id
     *
     * @return view Admin.question.show_edit_question_detail
     */
    public function showEditQuestionDetail($role_id)
    {
        $questions = $this->question->getQuestionsByRoleId($role_id);
        try {
            $questions = $this->question->getQuestionsByRoleId($role_id);

            return view('Admin.question.show_edit_question_detail', compact('questions'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 質問編集フォーム画面
     * @param int $question_id
     *
     * @return view Admin.question.show_edit_question_form
     */
    public function showEditQuestionForm($question_id)
    {
        try {
            $question = $this->question->getQuestionByQuestionId($question_id);

            return view('Admin.question.show_edit_question_form', compact('question'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 更新実行
     * @param Request $request
     *
     * @return view Admin.question.show_edit_question_detail
     */
    public function exeUpdateQuestion(QuestionEditRequest $request, $question_id)
    {
        try {
            DB::beginTransaction();
            $std_role = $this->question->getRoleIdByQuestionId($question_id)->role_id;

            $question = $this->question->getQuestion($question_id);
            $data = $request->only(['content', 'category']);

            $question->content = $data['content'];
            $question->category = $data['category'];
            $question->saveQuestion();
            DB::commit();

            return redirect()->route('showEditQuestionDetail', $std_role)->with('editMessage', '質問内容を更新しました。');
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 質問削除実行
     * @param int $question_id
     *
     * @return view Admin.question.show_edit_question_detail
     */
    public function exeDestroyQuestion($question_id)
    {
        try {
            // ルートパラメータ用role_idを取得(stdClass生成)
            $question_role_id = $this->question->getRoleIdByQuestionId($question_id);

            if (!empty($question_role_id)) {
                // 中間テーブルを削除→onDeleteCascade制約によりリレーション先のquestionsテーブルのレコードも削除
                $question = $this->question->getQuestion($question_id);
                $question->destroyQuestion();

                return redirect()->route('showEditQuestionDetail', $question_role_id->role_id)
                ->with('deleteMessage', '削除しました。');
            }
            \Log::error('question_userテーブルのカラムがnullです。');

            return redirect()->route('showEditQuestionDetail', $question_role_id->role_id)->with('errorMessage', '予期しないエラーが発生しました。この質問は削除できません。');
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 質問検索画面
     * @param Request $request
     *
     * @return view Admin.question.show_search_question
     */
    public function searchQuestion(Request $request)
    {
        try {
            $keyword = $request->input('keyword');
            $category = $request->input('category');
            $role_id = $request->input('role_id');

            $search_questions = $this->question->getSearchParameterOfQuestion($keyword, $category, $role_id)->paginate(10);

            return view('Admin.question.search_question', compact('keyword', 'category', 'role_id', 'search_questions'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }
}
