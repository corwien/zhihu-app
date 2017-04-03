<?php

namespace App\Http\Controllers;

use App\Notifications\NewMessageNotification;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use Auth;

class InboxController extends Controller
{

    protected $message;

    /**
     * InboxController constructor.
     */
    public function __construct(MessageRepository $message)
    {
        // 登录之后才可以访问该控制器
        $this->middleware('auth');

        $this->message = $message;
    }

    /**
     * 私信列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // $messages = Auth::user()->messages()->get()->groupBy('from_user_id');

        $messages = $this->message->getAllMessages();
        return view('inbox.index', ['messages' => $messages->unique('dialog_id')->groupBy('to_user_id')]);
    }

    /**
     * 对话列表
     * @param $dialogId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($dialogId)
    {
        // orderBy ==> latest()
        $messages = $this->message->getAllMessagesBy($dialogId);

        // 标记为已读
        $messages->markAsRead();
        return view('inbox.show', compact('messages', 'dialogId'));
    }

    public function store($dialogId)
    {
        $message = $this->message->getSingleMessageBy($dialogId);
        $toUserId = $message->from_user_id === Auth::id() ? $message->to_user_id : $message->from_user_id;

        $newMessage = $this->message->create([
            'from_user_id' => Auth::id(),
            'to_user_id'   => $toUserId,
            'body'         => request('body'),
            'dialog_id'    => $dialogId,
        ]);

        // 发送消息
        $newMessage->toUser->notify(new NewMessageNotification($newMessage));

        return back();
    }
}
