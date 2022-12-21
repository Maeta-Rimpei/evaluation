<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * 職員登録フォーム表示
     */
    protected function showRegistrationForm()
    {
        return view('admin.show_create_staff');
    }

    /**
     * 管理者登録フォーム表示
     */
    protected function showAdminRegistrationForm()
    {
        return view('admin.show_create_admin');
    }

    /**
     * 職員登録フォーム表示
     */
    protected function exeAdminRegistrationForm(StaffCreateRequest $request)
    {
        Admin::create([
            'staff_id' => $request->staff_id,
            'name' => $request->name,
            'role_id' => $request->role_id,
            'affiliation' => $request->affiliation,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('adminRegister')->with('createAdminMessage', '管理者を登録しました。');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(StaffCreateRequest $request)
    {
        User::create([
            'staff_id' => $request->staff_id,
            'name' => $request->name,
            'role_id' => $request->role_id,
            'affiliation' => $request->affiliation,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('register')->with('createMessage', '職員を登録しました。');
    }
}
