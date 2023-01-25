<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Staff;
use App\Models\Admin;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StaffCreateRequest;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    private $admin;
    private $staff;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->admin = new Admin;
        $this->staff = new Staff;
    }

    /**
     * 職員登録フォーム表示
     * @return view Admin.admin.show_registeration_staff_form
     */
    protected function showRegistrationStaffForm()
    {
        return view('Admin.staff.show_registeration_staff_form');
    }

    /**
     * 管理者登録フォーム表示
     * @return view Admin.admin.show_register_admin_form
     */
    protected function showRegistrationAdminForm()
    {
        return view('Admin.admin.show_register_admin_form');
    }

    /**
     * 管理者登録実行
     */
    protected function exeRegisterAdmin(StaffCreateRequest $request)
    {
        $inputs = $request->only(['staff_code', 'name', 'role_id', 'affiliation', 'password']);
        // dd($inputs);
        $users = $this->staff->getAllUsers();
        foreach ($inputs as $key => $val) {
            foreach ($users as $user) {
                if ($user[$key] == $val){
                    $common[] = $val;
                }
            }
        }
        dd($common);
        $this->admin->create([
            'staff_code' => $request->staff_code,
            'name' => $request->name,
            'role_id' => $request->role_id,
            'affiliation' => $request->affiliation,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('showRegistrationAdminForm')->with('createAdminMessage', '管理者を登録しました。');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function exeRegisterStaff(StaffCreateRequest $request)
    {
        $this->staff->create([
            'staff_code' => $request->staff_code,
            'name' => $request->name,
            'role_id' => $request->role_id,
            'affiliation' => $request->affiliation,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('register')->with('createMessage', '職員を登録しました。');
    }
}
