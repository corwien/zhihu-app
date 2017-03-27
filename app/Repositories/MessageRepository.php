<?php

namespace App\Repositories;

use App\Models\Message;

/**
 * Class MessageRepository
 *
 * @package \App\Repositories
 */
class MessageRepository
{
    public function create(array $attributes)
    {
        return Message::create($attributes);
    }

}
