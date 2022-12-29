<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StaffController extends Controller
{
    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = new User();
    }

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
            $user_questions_answers = $user->getQuestionsAndAnswers($id);

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

    //---------------------評価関係--------------------------------------
    public function evaluationStaff($id)
    {
        try {
            $user = $this->user->getUser($id);
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
            $evaluation = $request->only(['total_evaluation', 'evaluation']);
            $user->total_evaluation = $evaluation['total_evaluation'];
            $user->evaluation = $evaluation['evaluation'];
            $user->save();
            DB::commit();

            return redirect()->route('evaluationStaff', $user->id)->with('evaluationMessage', 'フィードバックコメントを送信しました。');
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error($e);
            throw $e;
        }
    }

    public function showEditEvaluationStaff($id)
    {
        try {
            $user = $this->user->getUser($id);
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }

        return view('admin.show_edit_evaluation', compact('user'));
    }

    public function exeEditEvaluationStaff($id, Request $request)
    {
        try {
            $user = $user = $this->user->getUser($id);
            $evaluation = $request->only(['evaluation']);
            $user->update($evaluation);
            return redirect()->route('showEditEvaluationStaff', $user->id)->with('evaluationUpdateMessage', 'フィードバックコメントを編集しました。');
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }
    public function exeDestroyedEvaluationStaff($id)
    {
        try {
            $user = $this->user->getUser($id);
            $user_evaluation = $this->user->getUser($id)->evaluation;
            $user_total_evaluation = $this->user->getUser($id)->total_evaluation;

            if (!empty($user_evaluation) && !empty($user_total_evaluation)) {
                $user->evaluation = '';
                $user->total_evaluation = '';
                $user->save();
                return redirect()->route('showStaffDetail', $user->id)->with('destroyedEvaluationMessage', 'フィードバックを削除しました。');
            } else {
                return redirect()->route('showStaffDetail', $user->id)->with('destroyedErrorMessage', 'この方へのフィードバックはまだできていません。');
            }
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    public function showDestroyedEvaluationStaff()
    {
        try {
            $users = $this->user->getAllUsers();
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }

        return view('admin.show_destroyed_evaluation', compact('users'));
    }

    public function exeDestroyedAllEvaluationStaff()
    {
        try {
            $users = $this->user->getAllUsers();
            foreach ($users as $user) {
                $user->evaluation = '';
                $user->total_evaluation = '';
                $user->save();
            }
            return redirect()->route('showStaff')->with('destroyedAllEvaluationMessage', '全職員のフィードバックを削除しました。');
        } catch (\Throwable $e) {
            \Log::error($e);
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
            $user = $this->user->findOrFail($id);
            $user->delete();
            return redirect()->route('showStaffSoftDeleted')->with('deleteMessage', '削除しました。');
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }
}