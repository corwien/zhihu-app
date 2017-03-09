<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use Naux\Mail\SendCloudTemplate;

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
    protected $redirectTo = '/home';

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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user =  User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'avatar'   => '/images/avatars/default.png',
            'phone'    => '',
            'confirmation_token' => str_random(40),
            'password' => bcrypt($data['password']),
        ]);

        $this->sendVerifyEmailTo($user);

        return $user;
    }


    /**
     * 邮箱验证
     * @param $user
     */
    public function sendVerifyEmailTo($user)
    {
        // 模板变量
        $bind_data = [
            'url' => route('email.verify', ['token' => $user->confirmation_token]),
            'name' => $user->name,
        ];
        $template = new SendCloudTemplate('zhihu_app_register', $bind_data);

        Mail::raw($template, function ($message) use ($user) {
            $message->from('407544577@qq.com', 'Zhihu');

            $message->to($user->email);
        });

    }
}
