<?php

namespace App\Repositories;

use App\Models\Message;
use Auth;

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

    public function getAllMessages()
    {
        $messages = Message::where('to_user_id', Auth::id())
            ->orWhere('from_user_id', Auth::id())
            ->with('fromUser', 'toUser')->latest()->get();

        return $messages;
    }

    /**
     * 获取对话列表信息
     * @return mixed
     */
    public function getAllMessagesBy($dialogId)
    {
        // orderBy ==> latest()
        return Message::where('dialog_id', $dialogId)->orderBy('created_at', 'desc')->get();
    }


    public function getSingleMessageBy($dialogId)
    {
        return Message::where('dialog_id', $dialogId)->first();
    }

}
