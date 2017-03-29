<?php

namespace App\Repositories;

use App\Models\Question;
use App\Models\Answer;


/**
 * Class AnswerRepository
 *
 * @package App\Repositories
 */
class AnswerRepository
{
    /**
     * @param $id
     *
     * @return mixed
     */
    public function byIdWithTopics($id)
    {
        return $question = Question::where('id', $id)->with('topics')->first();
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        return Answer::create($attributes);
    }

    public function byId($id)
    {
        return Answer::findOrFail($id);
    }

    /**
     * 获取回答的评论
     * @param $id
     *
     * @return mixed
     */
    public function getAnswerCommentsById($id)
    {
        $answer = Answer::with('comments', 'comments.user')
            ->where('id', $id)->first();

        return $answer->comments;
    }


}
