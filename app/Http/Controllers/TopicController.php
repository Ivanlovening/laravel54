<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    //
    public function show(Topic $topic){
        //带文章数的专题
        $topic = Topic::withCount('postTopics')->find($topic->id);
//        dd($topic);
        //专题的文章列表，按照创建时间倒叙排列
        $posts = $topic->posts()->orderBy('created_at','desc')->paginate(3);
        //传递属于我的文章，但未投稿
        $myposts = \App\Post::authorBy(\Auth::id())->topicNotBy($topic->id)->get();
        return view('topic.show',compact('topic','posts','myposts'));
    }
    //投稿
    public function submit(Topic $topic){
        //验证
        $this->validate(request(),[
           'post_ids' => 'required|array'
        ]);
        //逻辑
        $post_ids = request('post_ids');
        $topic_id = $topic->id;
        foreach ($post_ids as $post_id) {
            //有就取出来，没有就创建firstOrCreate
            \App\PostTopic::firstOrCreate(compact('post_id','topic_id'));
        }
        //渲染
        return back();
    }
}
