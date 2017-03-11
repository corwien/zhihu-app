<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class EmailController extends Controller
{

    public function verify($token)
    {
        $user = User::where("confirmation_token", $token)->first();

        // dd($user);
        if(empty($user))
        {
            flash("邮箱验证失败！", "danger");
            return redirect("/");
        }

        // 更新active
        $user->is_active = 1;
        $user->confirmation_token = str_random(40);
        $user->save();

        // 验证成功后，然后直接登录状态
        Auth::login($user);
        flash("邮箱验证成功！", "success");
        return redirect("/home");

    }
}
