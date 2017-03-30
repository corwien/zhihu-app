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
        $questions = $this->questionRepository->getQuestionsFeed();
        return view('questions.index', compact('questions'));
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
        $question = $this->questionRepository->byIdWithTopicsAndAnswers($id);

        if(empty($question)) abort(404, "NOT FOUND");

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
        $question = $this->questionRepository->byId($id);

        // 判断是否为本人，否则不能编辑
        if(Auth::user()->owns($question))
        {
            return view("questions.edit",  compact('question'));
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestionRequest $request, $id)
    {
        $question = $this->questionRepository->byId($id);
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));

        // 更新
        $question->update([
                'title' => $request->title,
                'body'  => $request->body,
            ]);

        // 更新第三张关系表
        $question->topics()->sync($topics);

        flash("恭喜你，更新成功！", "success");
        return redirect()->route('questions.show', [$question->id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = $this->questionRepository->byId($id);

        // 判断是否为本人，否则不能删除
        if(Auth::user()->owns($question))
        {
            $question->delete();

            // 删除第三张关系表
            // $question->topics()->where('question_id', $question->id)->delete();
            $question->topics()->detach();   // 移除关系表中的关联如果不删除，则会出现新添加的问题标签关联到旧的标签中。
            return redirect('/');
        }

        return back();
    }




}
