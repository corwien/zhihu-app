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
        return Question::findOrFail($id);
    }


    public function getQuestionsFeed()
    {
        // return Question::latest('updated_at')->with('user')->get();
        return Question::published()->latest('updated_at')->with('user')->get();
    }




}
