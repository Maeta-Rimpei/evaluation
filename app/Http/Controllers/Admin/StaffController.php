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

    /**
     * 職員一覧画面
     * @return view Admin.staff.show_staff
     */
    public function showStaff()
    {
        try {
            $users = $this->user->getAllUsers();
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
    public function showStaffDetail($id)
    {
        try {
            $user = $this->user->getUser($id);
            $user_questions_answers = $user->getQuestionsAndAnswers($id);

            // $user_questions_answersをstdClassから配列化
            $array_user_questions_answers = $this->user->conversionToArray($user_questions_answers);
            // 解答を集計
            $answers_count = array_count_values(array_column($array_user_questions_answers, 'answer'));

            return view('Admin.staff.show_staff_detail', compact('user', 'array_user_questions_answers', 'answers_count'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    //---------------------評価関係--------------------------------------
    /**
     * 職員評価画面
     * @param int $id users.id
     *
     * @return view Admin.staff.evaluation_staff
     */
    public function evaluationStaff($id)
    {
        try {
            $user = $this->user->getUser($id);
            return view('Admin.staff.evaluation_staff', compact('user'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 職員評価実行
     * @param int $id users.id
     *            Request $request
     * @return view Admin.staff.evaluation_staff
     */
    public function exeEvaluationStaff($id, Request $request)
    {
        try {
            DB::beginTransaction();
            $user = $user = $this->user->getUser($id);

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
     * @param int $id users.id
     *
     * @return view Admin.staff.show_edit_evaluation
     */
    public function showEditEvaluationStaff($id)
    {
        try {
            $user = $this->user->getUser($id);
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }

        return view('Admin.staff.show_edit_evaluation_staff', compact('user'));
    }

    /**
     * 職員評価更新実行
     * @param int $id users.id
     *            Request $request
     *
     * @return view Admin.staff.show_staff
     */
    public function exeUpdateEvaluationStaff($id, Request $request)
    {
        try {
            $user = $user = $this->user->getUser($id);

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

    /**
     * 評価削除実行
     * @param int $id users.id
     *
     * @return view Admin.staff.show_staff_detail
     */
    public function exeDestroyEvaluationStaff($id)
    {
        try {
            $user = $this->user->getUser($id);
            $user_evaluation = $this->user->getUser($id)->evaluation;
            $user_total_evaluation = $this->user->getUser($id)->total_evaluation;

            // 総合評価とフィードバックコメントが空の場合
            if (empty($user_evaluation) && empty($user_total_evaluation)) {
                return redirect()->route('showStaffDetail', $user->id)->with('destroyErrorMessage', 'この方へのフィードバックはまだできていません。');
            }

            // nullで上書きすることで削除
            $user->evaluation = '';
            $user->total_evaluation = '';
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
        /**
         *
         *
         *
         *
         *
         * 
         */
    }
    /**
     * 全評価削除実行
     * @return view Admin.staff.show_staff
     */
    public function exeDestroyAllEvaluationStaff()
    {
        try {
            $users = $this->user->getAllUsers();
            foreach ($users as $user) {
                $user->evaluation = '';
                $user->total_evaluation = '';
                $user->save();
            }
            return redirect()->route('showStaff')->with('destroyAllEvaluationMessage', '全職員のフィードバックを削除しました。');
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
            $users = $this->user->getAllUsers();
            return view('Admin.staff.show_delete_staff', compact('users'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 職員論理削除実行
     * @param int $id users.id
     *
     * @return view Admin.staff.show_delete_staff
     */
    public function exeSoftDeleteStaff($id)
    {
        try {
            $user = $this->user->getUser($id);
            $user->delete();
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

            return view('Admin.staff.search_staff', compact('name', 'staff_id', 'affiliation', 'user_affiliations', 'role_id', 'search_staffs'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }
}
