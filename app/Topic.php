<?php

namespace App;

use App\Model;

class Topic extends Model
{
    //多对多,属于这个专题的所有文章，肯定有中间表,第一个参数，第二参数中间表，第三个参数第四都是中间表两个id
    public function posts(){
        return $this->belongsToMany(\App\Post::class,'post_topics','topic_id','post_id');
    }
    //专题文章数,用于withCount计算专题文章数
    public function postTopics(){
        return $this->hasMany(\App\PostTopic::class,'topic_id','id');
    }
//    //删除某个专题
//    public function deleteTopic($topic){
//        return $this->posts->detach($topic);//增加save()
//    }
}
