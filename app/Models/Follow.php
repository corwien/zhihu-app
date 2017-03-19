<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    // 指定操作的表
    protected $table = "user_question";

    protected $fillable = ['user_id', 'question_id'];
}
