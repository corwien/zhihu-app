<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

}
