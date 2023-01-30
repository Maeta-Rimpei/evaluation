<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AnswerRequest;
use App\Models\Answer;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;

class AnswerController extends Controller
{
    private $answer;
    private $staff;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->answer = new Answer();
        $this->staff = new Staff();
    }

    /**
     * 回答編集画面
     * @return view Admin.answer.show_edit_answer
     */
    public function showEditAnswer()
    {
        try {
            $users = $this->staff->orderBy('created_at', 'desc')->paginate(10);

            return view('Admin.answer.show_edit_answer', compact('users'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 回答削除実行
     * @param int $staff_id staffs.id
     *
     * @return view show_edit_answer
     */
    public function exeDeleteAllAnswers($staff_id)
    {
        try {
            // 特定のユーザーの回答を一つ取得
            $user_answers = $this->answer->selectAnswerByStaffId($staff_id);

            // 空なら何もせずリダイレクト→回答していれば全ての問に対する回答あり→1つでも空なら全て空と判断
            if ($user_answers->isEmpty()) {
                return redirect()->route('showEditAnswer')->with('errorAnswerEmptyMessage', 'この方はまだ回答していません。');
            }

            $this->answer->deleteAllstaffAnswer($user_answers);

            return redirect()->route('showEditAnswer')->with('deleteAllAnswerMessage', '選択した方の回答を全て削除しました。');
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 回答個別編集画面
     * @param int $staff_id staffs.id
     *
     * @return view Admin.answer.show_edit_part_answer
     */
    public function showEditPartAnswer($staff_id)
    {
        try {
            $user = $this->staff->getUser($staff_id);
            $user_questions_answers = $this->staff->getQuestionsAndAnswers($staff_id);

            return view('Admin.answer.show_edit_part_answer', compact('user', 'user_questions_answers'));
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 回答編集フォーム画面
     * @param int $answer_id answers.id
     *
     * @return view Admin.answer.show_edit_answer_form
     */
    public function showEditAnswerForm($answer_id)
    {
        try {
            $user_answer = $this->answer->getAnswer($answer_id);
            $user_id = $user_answer->staff->id;

            return view('Admin.answer.show_edit_answer_form', compact('user_answer', 'user_id'));
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 回答更新実行
     * @param int $answer_id answers.id
     *        Request $request
     * @return view Admin.answer.show_edit_part_answer
     */
    public function exeUpdateAnswer($answer_id, AnswerRequest $request)
    {
        try {
            $answer = $request->only(['answer']);
            $user_answer = $this->answer->getAnswer($answer_id);
            $staff_id = $this->answer->getAnswer($answer_id)->staff->id;

            $user_answer->answer = $answer['answer'];
            $user_answer->saveAnswer();

            return redirect()->route('showEditPartAnswer', $staff_id)->with('updateAnswerMessage', '回答を修正しました。');
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }
}
