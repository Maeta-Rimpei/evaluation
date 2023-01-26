<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private $admin;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest:admin')->except('logout');
        $this->admin = new Admin();
    }

    // --------------------認証関係----------------------
    
    public function showLogin()
    {
        return view('admin.login');
    }
    
    public function login(LoginRequest $request)
    {
        try {
            
            if (\Auth::guard('admin')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect('admin/index');
            $credentials = $request->only('staff_code', 'password');
            }
            
            return redirect()->route('adminShowLogin')->with('loginErrorMessage', '職員コードかパスワードが間違っています。');
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
    public function index()
    {
        return view('admin.index');
    }

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
            $staff_code = $request->input('staff_code');
            $affiliation = $request->input('affiliation');
            $role_id = $request->input('role_id');

            $search_admins = $this->admin->getSearchParameterOfAdmin($name, $staff_code, $affiliation, $role_id)->paginate(10);

            return view('Admin.admin.search_admin', compact('name', 'staff_code', 'affiliation', 'role_id', 'search_admins'));
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
     * @param int $admin_id admins.id
     *
     * @return view Admin.admin.show_admin_soft_delete
     */
    public function exeSoftDeleteAdmin($admin_id)
    {
        try {
            $admin = $this->admin->getAdmin($admin_id);

            if ($this->admin->checkNumberOfAdmin()) {
                return redirect()->route('showSoftDeleteAdmin')->with('deleteErrorMessage', '管理者が残り一人です。削除できません。');
            }

            $admin->deleteAdmin();

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
        $admins = $this->admin->getSoftDeletedAdmins();

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
        $this->admin->exeRestoreSoftDeletedAdmin($admin_id);

        return redirect()->route('showHistoryOfSoftDeletedAdmin')->with('restoreAdminMessage', '管理者の復元に成功しました。');
    }
}
