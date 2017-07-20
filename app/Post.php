<?php

namespace App;
use \Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Searchable;
use \App\Model;
class Post extends Model
{
    /*
    use Searchable;
    //定义搜索索引里的type
    public function SearchableAs(){
        return 'post';
    }
    //定义要搜索的字段
    public function toSearchableArray()
    {
        return [
            'title'=>$this->title,
            'content'=>$this->content,
        ];
    }
    */
    //protected $guarded = [];不允许提交的字段，已经从主模型继承了
    //create允许接受的字段，类似tp的$insertFeilds
    protected  $fillable = ['title','content','user_id'];
    //文章关联用户（一对多反向）
    public function user(){
        //这篇文章属于这个用户
        return $this->belongsTo('App\User');
    }
    //评论模型(一对多）
    public function comments(){
        //这篇文章所有的评论并且按照评论时间降序排列
        return $this->hasMany('App\Comment')->orderBy('created_at','desc');
    }
    //赞，某个用户是否对该文章点赞
    public function zan($user_id){
        return $this->hasOne('App\Zan')->where('user_id',$user_id);
    }
    //该文章所有的赞

    public function zans(){
        return $this->hasMany(\App\Zan::class);
    }
    //属于某个作者的文章
    public function scopeAuthorBy(Builder $query,$user_id){
        return $query->where('user_id',$user_id);
    }
    //该文章属于多少个专题
    public function postTopics(){
        return $this->hasMany(\App\PostTopic::class,'post_id','id');
    }
    //不属于某个专题文章,先找该文章属于多少个专题，然后这些专题里面没有某个专题
    public function scopeTopicNotBy(Builder $query,$topic_id){
        return $query->doesntHave('postTopics','and',function($q) use($topic_id){
           $q->where('topic_id',$topic_id);
        });
    }
    //定义一个全局的匿名scope范围,调用post模型只获取的文章列表只包含状态为0，1的
    protected static function boot(){
        parent::boot();
        static::addGlobalScope('avaiable',function(Builder $builder){
            $builder->whereIn('status',[0,1]);
        });
    }
}
