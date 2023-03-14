<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected function redirectTo()
    {
        return url()->previous();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'ma_user' => ['required', 'integer', 'unique:users'],
            'ten_user' => ['required', 'string',],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'ma_user.required' => 'Không được bỏ trống trường này',
            'ma_user.unique' => 'Mã sinh viên đã tồn tại trong hệ thống',
            'ma_user.integer' => 'Mã sinh viên phải là số',


            'ten_user.required' => 'Không được bỏ trống trường này',

            'email.required' => 'Không được bỏ trống trường này',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'email.email' => 'Email không đúng định dạng',

            'password.required' => 'Không được bỏ trống trường này',
            'password.min' => 'Mật khẩu phải nhiều hơn 8 kí tự',


        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'ma_user' => $data['ma_user'],
            'ten_user' => Str::lower($data['ten_user']),
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
