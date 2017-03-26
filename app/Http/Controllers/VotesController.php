<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use Auth;

class VotesController extends Controller
{
    protected $answer;

    /**
     * VotesController constructor.
     *
     * @param $answer
     */
    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    /**
     * 判断是否点赞
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function users($id)
    {
        // 获取当前登录用户
        $user = Auth::guard('api')->user();

        if($user->hasVotedFor($id))
        {
            return response()->json(['voted' => true]);
        }

        return response()->json(['voted' => false]);
    }

    /**
     * 投票动作
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function vote(Request $request)
    {
        $answer = $this->answer->byId($request->get('answer'));
        $voted = Auth::guard('api')->user()->voteThis($request->get('answer'));

        if(count($voted['attached']) > 0)
        {

            $answer->increment('votes_count');
            return response()->json(['voted' => true]);
        }

        if($answer->votes_count > 0)
        {
            $answer->decrement('votes_count');
        }

        return response()->json(['voted' => false]);

    }
}
