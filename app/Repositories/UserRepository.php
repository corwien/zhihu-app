<?php

namespace App\Repositories;
use App\User;

class UserRepository
{

    /**
     * 获取用户信息
     * @param $id
     *
     * @return mixed
     */
    public function byId($id)
    {
        return User::find($id);
    }

}
