<?php

namespace App;

use App\Model;

class Fan extends Model
{
    //获取粉丝用户
    public function fuser(){
        return $this->hasOne(\App\User::class,'id','fan_id');
    }

}
