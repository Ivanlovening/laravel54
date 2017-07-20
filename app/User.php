<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //create可接受字段
    protected $fillable=['name','email','password','avatar'];
    //用户的文章列表
    public function posts(){
        return $this->hasMany(\App\Post::class,'user_id','id');
    }
    //关注我的fan模型
    public function fans(){
        return $this->hasMany(\App\Fan::class,'star_id','id');
    }
    //我关注的star模型
    public function stars(){
        return $this->hasMany(\APP\Fan::class,'fan_id','id');

    }
    //点击关注
    public function doFan($uid){
        $fan = new \App\Fan();
        $fan->star_id = $uid;
        return $this->stars()->save($fan);
    }
    //点击取消关注
    public function doUnFan($uid){
        $fan = new \App\Fan();
        $fan->star_id = $uid;
        return $this->stars()->delete($fan);
    }
    //当前用户是否被uid关注了，是否有粉丝
    public function hasFan($uid){
        return $this->fans()->where('fan_id',$uid)->count();
    }
    //当前用户是否关注了uid
    public function hasStar($uid){
        return $this->stars()->where('star_id',$uid)->count();
    }
    //用户收到的通知多对多
    public function notices(){
        return $this->belongsToMany(\App\Notice::class,'user_notice','user_id','notice_id')->withPivot(['user_id','notice_id']);
    }
    //增加通知
    public function addNotice($notice){
        return $this->notices()->save($notice);//删除用detach
    }
    //删除通知
    public function deleteNotice($notice){
        return $this->notices()->detach($notice);//删除用detach
    }
    //默认头像
    public function getDefaultAvatar($value){
        if(empty($value)){
            return '/storage/bf96799c080c6eb56fe752f8036a0397/3uKwARhWDa1hXhfTtjJr8MN7TnvHXpYNMYWbJITN.jpeg';
        }
        return $value;
    }
}
