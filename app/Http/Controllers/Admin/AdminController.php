<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\AnswerRequest;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private $admin;

    private $answer;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->admin = new Admin();
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
    /**
     * 管理者一覧画面
     * @return view Admin.admin.show_admin
     */
    public function showAdmin()
    {
        try {
            $admins = $this->admin->getAllAdmins();

            return view('Admin.admin.show_admin', compact('admins'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 管理者検索
     * @param Request $request
     *
     * @return view Admin.admin.show_search_admin
     */
    public function searchAdmin(Request $request)
    {
        try {
            $name = $request->input('name');
            $staff_id = $request->input('staff_id');
            $affiliation = $request->input('affiliation');
            $role_id = $request->input('role');

            $search_admins = $this->admin->searchAdmin($name, $staff_id, $affiliation, $role_id)->paginate(10);


            // $query = $this->admin->query();
            
            // if (isset($name)) {
            //     // $this->admin->likeSearchAdmin($name);
            //     $name_push_array = $this->admin->spaceConversionAndPushArray($name);
            //     $this->admin->likeSearch($name_push_array, 'name');
            //     }
                
            // if (isset($staff_id)) {
            //     $staff_id_push_array = preg_split('/[\s,]+/', $staff_id, -1, PREG_SPLIT_NO_EMPTY);

            //     foreach ($staff_id_push_array as $word) {
            //         $query->where('staff_id', 'LIKE', '%' . self::escape($staff_id) . '%');
            //     }
            // }

            // if (isset($affiliation)) {
            //     $space_conversion = mb_convert_kana($name, 's');

            //     $affiliation_push_array = preg_split('/[\s,]+/', $space_conversion, -1, PREG_SPLIT_NO_EMPTY);

            //     foreach ($affiliation_push_array as $word) {
            //         $query->where('name', 'LIKE', '%' . self::escape($word) . '%');
            //     }
            // }

            // if (isset($request->role_id)) {
            //     $query->when($request, function ($query, $request) {
            //         return $query->where('role_id', '=', $request->role_id);
            //     });
            // }

            // $search_admins = $query->orderBy('admins.created_at', 'desc')->paginate(10);

            return view('Admin.admin.search_admin', compact('name', 'staff_id', 'affiliation', 'role_id', 'search_admins'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 管理者論理削除画面
     * @return view Admin.admin.show_deleted_admin
     */
    public function showSoftDeleteAdmin()
    {
        try {
            $admins = $this->admin->getAllAdmins();

            return view('Admin.admin.show_delete_admin', compact('admins'));
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

    /**
     * 管理者論理削除実行
     * @param int $id
     *
     * @return view Admin.admin.show_admin_soft_delete
     */
    public function exeSoftDeleteAdmin($id)
    {
        try {
            $admin = $this->admin->getAdmin($id);
            $all_admins = $this->admin->getAllAdmins()->toArray();

            if (count($all_admins) == 1) {
                return redirect()->route('showSoftDeleteAdmin')->with('deleteErrorMessage', '管理者が残り一人です。削除できません。');
            }

            $admin->delete();

            return redirect()->route('showSoftDeleteAdmin')->with('deleteMessage', '削除しました。');
        } catch (\Throwable $e) {
            \Log::error($e);
            throw $e;
        }
    }

     /**
     * 管理者論理削除履歴一覧画面
     * @return view Admin.staff.show_history_of_deleted_staff
     */
    public function showHistoryOfSoftDeletedAdmin()
    {
        $admins = $this->admin->onlyTrashed()->whereNotNull('id')->get();

        return view('Admin.admin.show_history_of_deleted_admin', compact('admins'));
    }

/**
     * 論理削除済管理者復元実行
     * @param int $admin_id admins.id
     * 
     * @return view Admin.staff.show_history_of_deleted_staff
     */
    public function exeRestoreHistoryOfSoftDeletedAdmin($admin_id)
    {
        $admin = $this->admin->onlyTrashed()->whereId($admin_id);
        $admin->restore();

        return redirect()->route('showHistoryOfSoftDeletedAdmin')->with('restoreAdminMessage', '管理者の復元に成功しました。');
    }


    public static function escape($str)
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $str);
    }
}
