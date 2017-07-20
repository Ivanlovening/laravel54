<?php
namespace App\Admin\Controllers;

use App\Post;

class PostController extends Controller{
    public function index(){
        $posts = Post::withoutGlobalScope('avaiable')->where('status',0)->paginate(3);
        return view('admin.post.index',compact('posts'));
    }
    //ajax审核
    public function status(Post $post){
        //验证
        $this->validate(request(),[
           'status'=>'required|in:1,-1',
        ]);
        //逻辑
        $post->status = request('status');
        $post->save();
        //渲染
        return [
          'error' => 0,
            'msg' => ''
        ];
    }
    //文章详情页
    public function show(Post $post){
        return view('admin.post.show',compact('post'));
    }
}