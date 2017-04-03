<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\MessageCollection;
use Auth;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = ['from_user_id', 'to_user_id', 'body', 'read_at', 'has_read', 'dialog_id'];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    /**
     * 私信是否读取
     */
    public function markAsRead()
    {
        if(is_null($this->read_at))
        {
            $this->forceFill(['has_read' => 'T', 'read_at' => $this->freshTimestamp()])->save();
        }
    }

    public function newCollection(array $models = [])
    {
        return new MessageCollection($models);
    }

    public function read()
    {
        return $this->has_read == 'F';
    }

    public function unread()
    {
        return $this->has_read == 'F';
    }


    public function shouldAddUnreadClass()
    {
        if(Auth::id() == $this->from_user_id)
        {
            return false;
        }

        return $this->unread();

    }


}
