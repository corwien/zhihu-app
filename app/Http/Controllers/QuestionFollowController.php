<?php

namespace App\Http\Controllers;

use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;

use Auth;

class QuestionFollowController extends Controller
{

    protected $question;

    /**
     * 加中间件权限验证，只有登录的用户才可以进行下面的关注动作操作
     * QuestionFollowController constructor.
     */
    public function __construct(QuestionRepository $question)
    {
        $this->middleware('auth');

        $this->question = $question;
    }

    /**
     * 关注问题
     * @param $question
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function follow($question)
    {
        Auth::user()->followThis($question);
        return back();
    }


    /**
     *  关注按钮,是否已经关注
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function follower(Request $request)
    {
        // $user = Auth::guard('api')->user();
        $user = user('api');
        if($user->followed($request->get('question')))
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
    public function followThisQuestion(Request $request)
    {
        // $user = Auth::guard('api')->user();
        // $question = Question::find($request->get('question'));
        $question = $this->question->byId($request->get('question'));
        $followed = user('api')->followThis($question->id);
        /*
        dd($followed);
        array:2 [
           "attached" => []
            "detached" => array:1 [
             0 => 10
            ]
          ]
        */

        if(count($followed['detached']) > 0)
        {
            $question->decrement('followers_count');
            return response()->json(['followed' => false]);
        }
        $question->increment('followers_count');

        return response()->json(['followed' => true]);

    }




}
