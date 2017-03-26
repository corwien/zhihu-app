<?php

namespace App;

use App\Models\Answer;
use App\Models\Follow;
use App\Models\Question;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Mailer\UserMailer;

use Mail;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','confirmation_token','phone','api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * 用户和答案关系
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * 判断是否为用户自己
     * @param \App\Model $model
     *
     * @return bool
     */
    public function owns(Model $model)
    {
        return $this->id === $model->user_id;
    }

    /**
     * 关注问题
     * @param $question
     *
     * @return mixed
     */
    public function _test_follows($question)
    {
        return Follow::create([
               'question_id' => $question,
                'user_id'    => $this->id
            ]);
    }

    /**
     * 关注问题(重写上边的方法，定义多对多的关系）
     * @param $question
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function follow()
    {
        // 如果不添加该方法，withTimestamps()，则关系表中的created_at 字段会为空
        return $this->belongsToMany(Question::class, 'user_question')->withTimestamps();
    }

    /**
     * 使用 toggle 方法可以很容易的实现多对多的关注问题，如果已经关注了，再次点击就可直接删除关系表中的关注记录。
     * @param $question
     *
     * @return mixed
     */
    public function followThis($question)
    {
        return $this->follow()->toggle($question);
    }

    /**
     * 用户是否关注问题
     * @param $question
     *
     * @return mixed
     */
    public function followed($question)
    {
        return $this->follow()->where('question_id', $question)->count();
    }

    /**
     * 用户的关注和被关注者的关联关系
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(self::class, "followers", 'follower_id', 'followed_id')->withTimestamps();
    }

    /**
     * 关注用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followersUser()
    {
        return $this->belongsToMany(self::class, "followers", 'followed_id', 'follower_id')->withTimestamps();
    }

    /**
     * 用户回答投票（点赞）多对多关系
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function votes()
    {
        // 如果不添加该方法，withTimestamps()，则关系表中的created_at 字段会为空
        return $this->belongsToMany(Answer::class, "votes")->withTimestamps();
    }

    /**
     * 用户投票动作
     * @param $answer
     *
     * @return array
     */
    public function voteThis($answer)
    {
        return $this->votes()->toggle($answer);
    }

    /**
     * 判断是否已经点赞过
     * @param $answer
     *
     * @return mixed
     */
    public function hasVotedFor($answer)
    {
        return !! $this->votes()->where('answer_id', $answer)->count();
    }

    /**
     * 关注用户动作
     * @param $user
     *
     * @return array
     */
    public function followThisUser($user)
    {
        return $this->followers()->toggle($user);
    }



    /**
     * 重写重置密码的邮件发送通知，覆盖zhihu_app_reset_password底层的发送方法
     * @param $token
     */
    public function sendPasswordResetNotification($token)
    {
        /*
        // 模板变量
        $bind_data = [
            'url' => url('password/reset', $token),
        ];
        $template = new SendCloudTemplate('zhihu_app_reset_password', $bind_data);

        Mail::raw($template, function ($message){

            $message->from('corwien@qq.com', 'Zhihu');

            $message->to($this->email);
        });
        */
        // 重构发送邮件
        (new UserMailer())->resetPassword($token, $this->email);

    }


}
