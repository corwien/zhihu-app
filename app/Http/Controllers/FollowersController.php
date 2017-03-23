<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Auth;

class FollowersController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }


    /**
     * 获取当前登录的用户是否关注了作者
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        // 作者信息
        $user = $this->user->byId($id);
        $follwers = $user->followersUser()->pluck('follower_id')->toArray();   // 获取作者的粉丝

        // Auth::guard('api')->user()->id  当前登录用户
        if(in_array(Auth::guard('api')->user()->id, $follwers))
        {
            return response()->json(['followed' => true]);
        }

        return response()->json(['followed' => false]);
    }

    /**
     * 关注动作
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function follow(Request $request)
    {
        $userFollow = $this->user->byId($request->get('user'));

        $followed = Auth::guard('api')->user()->followThisUser($userFollow->id);

        if(count($followed['attached']) > 0)
        {
            $userFollow->increment('followers_count');
            return response()->json(['followed' => true]);
        }
        $userFollow->decrement('followers_count');

        return response()->json(['followed' => false]);

    }
}
