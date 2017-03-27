<?php

namespace App\Http\Controllers;

use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use Auth;

class MessagesController extends Controller
{
    protected $message;

    /**
     * MessagesController constructor.
     *
     * @param $message
     */
    public function __construct(MessageRepository $message)
    {
        $this->message = $message;
    }


    public function store()
    {
        $message_res = $this->message->create([
            'to_user_id'   => request('user'),
            'from_user_id' => Auth::guard('api')->user()->id,
            'body'         => request('body'),
        ]);

        if($message_res)
        {
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }
}
