<?php

namespace App\Repositories;

use App\Models\Question;
use App\Models\Topic;


/**
 * Class QuestionRepository
 *
 * @package App\Repositories
 */
class QuestionRepository
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
        return Question::create($attributes);
    }


    public function normalizeTopic(array $topics)
    {
        return collect($topics)->map(function ($topic){
            if(is_numeric($topic)){

                // 引用数递增
                Topic::find($topic)->increment('questions_count');
                return (int)$topic;
            }

            $newTopic = Topic::create(['name' => $topic, 'questions_count' => 1]);
            return $newTopic->id;
        })->toArray();

    }


}
