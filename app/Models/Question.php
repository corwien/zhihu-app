<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Question extends Model
{
    protected $fillable = ['title', 'body', 'user_id'];


    /**
     * Eloquent 多对多关联
     */
    public function topics()
    {
        return $this->belongsToMany(Topic::class)->withTimestamps();
    }

    /**
     * 问题和用户关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 问题关联
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }


    /**
     * 关注者
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_question')->withTimestamps();
    }

    /**
     * 判断该问题是否被隐藏
     * @param $query
     *
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('is_hidden', 'F');
    }



}
