<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StaffController extends Controller
{
    private $staff;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->staff = new Staff();
    }

    /**
     * 職員一覧画面
     * @return view Admin.staff.show_staff
     */
    public function showStaff()
    {
        try {
            $users = $this->staff->orderBy("created_at", "desc")->paginate(10);
            return view('Admin.staff.show_staff', compact('users'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 職員詳細画面
     * @return view Admin.staff.show_staff_detail
     */
    public function showStaffDetail($staff_id)
    {
        try {
            $user = $this->staff->getUser($staff_id);
            $user_questions_answers = $user->getQuestionsAndAnswers($staff_id);

            // $user_questions_answersをstdClassから配列化
            $array_user_questions_answers = $this->staff->conversionToArray($user_questions_answers);
            // 2次元配列からanswer keyを抽出してカウント
            $answers_count = $this->staff->conversionAndArrayCountValues($array_user_questions_answers, 'answer');

            return view('Admin.staff.show_staff_detail', compact('user', 'array_user_questions_answers', 'answers_count'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    //---------------------評価関係--------------------------------------
    /**
     * 職員評価画面
     * @param int $staff_id staffs.id
     *
     * @return view Admin.staff.evaluation_staff
     */
    public function evaluationStaff($staff_id)
    {
        try {
            $user = $this->staff->getUser($staff_id);
            return view('Admin.staff.evaluation_staff', compact('user'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 職員評価実行
     * @param int $staff_id staffs.id
     *            Request $request
     * @return view Admin.staff.evaluation_staff
     */
    public function exeEvaluationStaff($staff_id, Request $request)
    {
        try {
            DB::beginTransaction();
            $user = $user = $this->staff->getUser($staff_id);

            if (!empty($user->evaluation)) {
                return redirect()->route('evaluationStaff', $user->id)->with('evaluationErrorMessage', 'この方のフィードバックは実施済みです。');
            }

            $evaluation = $request->only(['total_evaluation', 'evaluation']);
            $user->total_evaluation = $evaluation['total_evaluation'];
            $user->evaluation = $evaluation['evaluation'];
            $user->save();
            DB::commit();

            return redirect()->route('evaluationStaff', $user->id)->with('evaluationMessage', 'フィードバックを送信しました。');
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 職員評価編集画面
     * @param int $staff_id staffs.id
     *
     * @return view Admin.staff.show_edit_evaluation
     */
    public function showEditEvaluationStaff($staff_id)
    {
        try {
            $user = $this->staff->getUser($staff_id);
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }

        return view('Admin.staff.show_edit_evaluation_staff', compact('user'));
    }

    /**
     * 職員評価更新実行
     * @param int $staff_id staffs.id
     *            Request $request
     *
     * @return view Admin.staff.show_staff
     */
    public function exeUpdateEvaluationStaff($staff_id, Request $request)
    {
        try {
            $user = $user = $this->staff->getUser($staff_id);

            if (empty($user->evaluation)) {
                return redirect()->route('showEditEvaluationStaff', $user->id)->with('evaluationUpdateErrorMessage', 'この方のフィードバックはまだありません。');
            }

            $evaluation = $request->only(['evaluation']);
            $user->update($evaluation);
            return redirect()->route('showEditEvaluationStaff', $user->id)->with('evaluationUpdateMessage', 'フィードバックコメント更新しました。');
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    // -----------------------職員削除・編集------------------------------
    /**
     * 職員情報編集画面
     * @param int $staff_id
     */
    public function showEditStaff($staff_id)
    {
        try {
            $user = $this->staff->getUser($staff_id);

            return view('show_edit_staff', compact($user));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 評価削除実行
     * @param int $staff_id staffs.id
     *
     * @return view Admin.staff.show_staff_detail
     */
    public function exeDestroyEvaluationStaff($staff_id)
    {
        try {
            $user = $this->staff->getUser($staff_id);
            $user_evaluation = $this->staff->getUser($staff_id)->evaluation;
            $user_total_evaluation = $this->staff->getUser($staff_id)->total_evaluation;

            // 総合評価とフィードバックコメントが空の場合
            if ($this->staff->checkEmptyEvaluation()) {
                return redirect()->route('showStaffDetail', $user->id)->with('destroyErrorMessage', 'この方へのフィードバックはまだできていません。');
            }

            // nullで上書きすることで削除
            $user->evaluation = null;
            $user->total_evaluation = null;
            $user->save();

            return redirect()->route('showStaffDetail', $user->id)->with('destroyEvaluationMessage', 'フィードバックを削除しました。');
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 全評価削除画面
     * @return view Admin.staff.show_destroy_all_evaluation_staff
     */
    public function showDestroyAllEvaluationStaff()
    {
        $users = $this->staff->getAllUsers();

        return view('Admin.staff.show_destroy_all_evaluation_staff', compact('users'));
    }
    /**
     * 全評価削除実行
     * @return view Admin.staff.show_staff
     */
    public function exeDestroyAllEvaluationStaff()
    {
        try {
            if ($this->staff->checkEmptyEvaluation()) {
                return redirect()->route('showDestroyAllEvaluationStaff')->with('destroyErrorMessage', '削除できる総合評価およびフィードバックコメントがありません。');
            }

            $this->staff->exeDeleteStaffEvaluation();

            return redirect()->route('showDestroyAllEvaluationStaff')->with('destroyAllEvaluationMessage', '全職員のフィードバックを削除しました。');
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 職員論理削除
     * @return view Admin.staff.show_delete_staff
     */
    public function showSoftDeleteStaff()
    {
        try {
            $users = $this->staff->getAllUsers();
            return view('Admin.staff.show_delete_staff', compact('users'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 職員論理削除実行
     * @param int $staff_id staffs.id
     *
     * @return view Admin.staff.show_delete_staff
     */
    public function exeSoftDeleteStaff($staff_id)
    {
        try {
            $user = $this->staff->getUser($staff_id);
            $user->deleteStaff();
            return redirect()->route('showSoftDeleteStaff')->with('deleteMessage', '削除しました。');
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 職員検索
     * @param Request $request
     *
     * @return void
     */
    public function searchStaff(Request $request)
    {
        try {
            $name = $request->input('name');
            $staff_code = $request->input('staff_code');
            $affiliation = $request->input('affiliation');
            $role_id = $request->input('role_id');

            $search_staffs = $this->staff->getSearchParameterOfStaff($name, $staff_code, $affiliation, $role_id)->paginate(10);

            return view('Admin.staff.search_staff', compact('name', 'staff_code', 'affiliation', 'role_id', 'search_staffs'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 職員論理削除履歴一覧画面
     * @return view Admin.staff.show_history_of_deleted_staff
     */
    public function showHistoryOfSoftDeletedStaff()
    {
        $users = $this->staff->getSoftDeletedStaffs();

        return view('Admin.staff.show_history_of_deleted_staff', compact('users'));
    }

    /**
     * 論理削除済職員復元実行
     * @param int $staff_id staffs.id
     *
     * @return view Admin.staff.show_history_of_deleted_staff
     */
    public function exeRestoreHistoryOfSoftDeletedStaff($staff_id)
    {
        $user = $this->staff->exeRestoreSoftDeletedStaff($staff_id);

        return redirect()->route('showHistoryOfSoftDeletedStaff')->with('restoreStaffMessage', '職員の復元に成功しました。');
    }
}
