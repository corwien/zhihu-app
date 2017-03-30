<?php

namespace App\Repositories;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TopicRepository
 *
 * @package \App\Repositories
 */
class TopicRepository
{

    public function getTopicsForTagging(Request $request)
    {
        $topics = \App\Models\Topic::select(['id', 'name'])
            ->where('name', 'like', '%'.$request->query('q').'%')
            ->get();

        return $topics;
    }

}
