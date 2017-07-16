<?php

namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //文章列表页
    public function index(){
        //获取文章，所有
        $posts = Post::orderBy('created_at','desc')->paginate(6);
        return view('post.index',compact('posts'));
    }
    //文章详情
    public function show(Post $post){
        return view('post.show',compact('post'));
    }
    //创建文章
    public function create(){

        return view('post.create');
    }
    //保存文章Post $post
    public function store(Post $post){

    }
    //编辑文章Post $post
    public function edit(Post $post){

        return view('post.edit');
    }
    //更新文章
    public function update(Post $post){

    }

}
