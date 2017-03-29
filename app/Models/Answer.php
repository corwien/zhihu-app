<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Answer extends Model
{
    protected $fillable = ['question_id', 'body', 'user_id'];

    /**
     * 与用户关联
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * 获取所有回答的评论
     */
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }
}
