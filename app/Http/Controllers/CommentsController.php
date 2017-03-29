<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;
use App\Repositories\CommentRepository;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;

use Auth;

class CommentsController extends Controller
{
    protected $answer;
    protected $question;
    protected $comment;

    /**
     * CommentsController constructor.
     *
     * @param $answer
     * @param $question
     * @param $comment
     */
    public function __construct(AnswerRepository $answer, QuestionRepository $question, CommentRepository $comment)
    {
        $this->answer = $answer;
        $this->question = $question;
        $this->comment = $comment;
    }


    /**
     * 获取答案评论
     * @param $id
     *
     * @return mixed
     */
    public function answer($id)
    {
        return $this->answer->getAnswerCommentsById($id);
    }

    /**
     * 获取问题评论
     * @param $id
     *
     * @return mixed
     */
    public function question($id)
    {
        return $this->question->getQuestionCommentsById($id);
    }

    public function store()
    {
        $model = $this->getModelNameFromType(request('type'));

        $comment = $this->comment->create([
            'commentable_id'   => request('model'), // question_id/answer_id
            'commentable_type' => $model,
            'user_id'          => Auth::guard('api')->user()->id,
            'body'             => request('body'),
        ]);

        return $comment;
    }

    public function getModelNameFromType($type)
    {
        return $type === 'question' ? 'App\Models\Question' : 'App\Models\Answer';
    }
}
