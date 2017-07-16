<?php

namespace App;
use \App\Model;
class Post extends Model
{
    //protected $guarded = [];不允许提交的字段，已经从主模型继承了
    //create允许接受的字段，类似tp的$insertFeilds
    protected  $fillable = ['title','content'];
}
