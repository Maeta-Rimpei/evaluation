<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AnswerRequest;
use App\Models\Answer;
use App\Models\User;

class AnswerController extends Controller
{
    private $answer;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->answer = new Answer();
        $this->user = new User();
    }

    /**
     * 回答編集画面
     * @return view admin.show_edit_answer
     */
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


    /**
     * 回答削除実行
     * @param int $id users.id
     *
     * @return view show_edit_answer
     */
    public function exeDeleteAllAnswers($id)
    {
        try {
            // 特定のユーザーの回答を一つ取得
            $user_answer = $this->answer->where('user_id', '=', $id)->first();
            // 空なら何もせずリダイレクト→回答していれば全ての問に対する回答あり→1つでも空なら全て空
            if (empty($user_answer)) {
                return redirect()->route('showEditAnswer')->with('errorAnswerEmptyMessage', 'この方はまだ回答していません。');
            }

            $user_answer->delete();

            return redirect()->route('showEditAnswer')->with('deleteAllAnswerMessage', '回答を全て削除しました。');
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 回答個別編集画面
     * @param int $id users.id
     *
     * @return view admin.show_edit_part_answer
     */
    public function showEditPartAnswer($id)
    {
        try {
            $user = $this->user->getUser($id);
            $user_questions_answers = $this->user->getQuestionsAndAnswers($id);

            return view('admin.show_edit_part_answer', compact('user', 'user_questions_answers'));
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
     * @return
     */
    public function showEditAnswerForm($answer_id)
    {
        try {
            $user_answer = $this->answer->getAnswer($answer_id);

            return view('admin.show_edit_answer_form', compact('user_answer'));
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
     * @return view admin.show_edit_part_answer
     */
    public function exeUpdateAnswer($answer_id, AnswerRequest $request)
    {
        try {
            $answer = $request->only(['answer']);
            $user_answer = $this->answer->getAnswer($answer_id);
            $user_id = $this->answer->getAnswer($answer_id)->user->id;

            $user_answer->update($answer);

            return redirect()->route('showEditPartAnswer', $user_id)->with('updateAnswerMessage', '回答を修正しました。');
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }
}
