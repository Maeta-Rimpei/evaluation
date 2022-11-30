<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ResgisterRequest;

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'staff_id' => ['required', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'role_id' => ['required', 'int', 'max:1'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmed' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * 職員登録フォーム表示
     */
    protected function showRegistrationForm()
    {
        return view('admin.show_create_staff');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(ResgisterRequest $request)
    {
        User::create([
            'staff_id' => $request->staff_id,
            'name' => $request->name,
            'role_id' => $request->role_id,
            'affiliation' => $request->affiliation,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('register');
    }
}