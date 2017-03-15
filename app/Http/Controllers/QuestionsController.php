<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;

use Auth;

/**
 * Class QuestionsController
 *
 * @package App\Http\Controllers
 */
class QuestionsController extends Controller
{
    protected $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        // 未登录的用户，某些动作不能操作
        $this->middleware('auth')->except(['index', 'show']);

        // 注入
        $this->questionRepository = $questionRepository;
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
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        // $answer = $request->all();
        // dd($answer);
        // $this->validate($request, $rules, $messages);

        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));

        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'user_id' => Auth::id(),
        ];
        $question = $this->questionRepository->create($data);

        // 问题关联话题
        $question->topics()->attach($topics);

        flash("恭喜你，发布成功！", "success");
        return redirect()->route('questions.show', [$question->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 关联查询
        // $question = Question::findOrFail($id);
        // dd($question->topics);

        // 这里将下面的方法进行分离，应用注入代替下面的方法
        // $question = Question::where('id', $id)->with('topics')->first();
        $question = $this->questionRepository->byIdWithTopics($id);

        return view('questions.show', compact('question'));
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
