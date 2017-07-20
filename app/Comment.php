<?php

namespace App;

use App\Model;

class Comment extends Model
{
    //proteced $table='comments';

    //文章模型(1对多的反向）
    public function post()
    {
        //这个评论属于这篇文章
        return $this->belongsTo('App\Post');
    }
    //用户模型（1对多的反向）
    public function user(){
        return $this->belongsTo('App\User');
    }
}
