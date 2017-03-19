<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     *
     * Handle a login request to the application.
     * @update desc :在原有的登录操作基础上重写登录，增加登录成功提示及是否激活验证【20170310】
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request))
        {

            // 登录成功后，判断账号是否激活
            if(Auth::user()->is_active)
            {
                flash("欢迎回来！", "success");
                return $this->sendLoginResponse($request);
            }
            else
            {
                Auth::logout();
                flash('你的账号未激活，请检查邮箱中的注册邮件进行激活。', 'warning');
                return redirect('/login');
            }

        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        // 增加是否激活验证
        // $credentials = array_merge($this->credentials($request), ['is_active' => 1]);
        $credentials = $this->credentials($request);  // 这里换一个思路处理，登录成功后再验证是否激活，如果没有激活则退出登录，给出需要激活的提示，并重定向到首页。

        return $this->guard()->attempt(
            $credentials, $request->has('remember')
        );
    }


}
