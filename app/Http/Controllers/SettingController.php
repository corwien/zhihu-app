<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // dd(user()->settings);
        return view('users.setting');
    }

    /**
     * 保存更改【20170408】
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // array_only()方法支取到需要的字段
        // dd(user()->settings);
        /*
        $user_settings = user()->settings;
        $settings = array_merge((array)$user_settings, array_only($request->all(), ['city', 'bio']));

        user()->update(['settings' => $settings]);
        */

        // 将上边的一堆代码封装为单一原则
        user()->settings()->merge($request->all());
        flash("更新成功！", "success");
        return back();

    }
}
