<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreAnswerRequest;
use App\Repositories\AnswerRepository;

use Auth;

class AnswersController extends Controller
{
    protected $answerRepository;

    public function __construct(AnswerRepository $answerRepository)
    {
        // 未登录的用户，某些动作不能操作
        $this->middleware('auth')->except(['index', 'show']);

        // 注入
        $this->answerRepository = $answerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnswerRequest $request, $question)
    {
        $data = [
            'body'        => $request->get('body'),
            'user_id'     => Auth::id(),
            'question_id' => $question
        ];
        $answer = $this->answerRepository->create($data);

        // 利用answer和question关联 ，增加question表中的答案数递增
        $answer->question()->increment('answers_count');

        flash("恭喜你，评论成功！", "success");
        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
