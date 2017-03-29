<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = ['user_id', 'body', 'commentable_id', 'commentable_type'];

    /**
     * 多态关联允许一个模型在单个关联中从属一个以上其它模型。举个例子，想象一下使用你应用的用户可以「评论」文章和视频。
     * 使用多态关联关系，您可以使用一个 comments 数据表就可以同时满足两个使用场景。
     * 首先，让我们观察一下用来创建这关联的数据表结构：
     *
     *
     * 多态关联详情请看下边的文档：
     * http://d.laravel-china.org/docs/5.4/eloquent-relationships#polymorphic-relations
     * http://www.jianshu.com/p/d7e5ee17e5ed
     */

    /**
     * 声明多态关联
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
