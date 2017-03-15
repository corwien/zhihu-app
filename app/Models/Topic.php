<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Question\Question;

class Topic extends Model
{
    protected $fillable = ['name', 'bio', 'questions_count'];

    /**
     * Eloquent 多对多关联
     */
    public function qustions()
    {
        return $this->belongsToMany(Question::class)->withTimestamps();
    }
}
