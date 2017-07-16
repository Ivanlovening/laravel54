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
        //方法1：插入前先验证，控制器自带的validate
//        $this->validate(request(),[
//           'title'=>'required|string|max:100|min:5',
//            'content'=>'required|string|min:10'
//        ]);
        //方法2：validator验证
        $validator = \Validator::make(request()->input(),[
            'title'=>'required|string|max:100|min:5',
            'content'=>'required|string|min:10'
        ],[
            'required'=>':attribute为必填项',
            'string'=>':attribute为字符串',
            'max'=>':attribute太长',
            'min'=>':attribute太短'
        ],[
            'title'=>'标题',
            'content'=>'文章内容'
        ]);
        if($validator->fails()){
            /**验证失败返回原页面，并且携带错误提示信息，以及填写的表单值**/
            //withInput携带填写值，数据值持久化，模板中old(key)进行显示
            return redirect()->back()->withErrors($validator)->withInput();
        }
        /****验证后插入数据库******/
        Post::create(request(['title','content']));
        //添加成功，返回列表页
        return redirect('/posts');
    }
    //编辑文章Post $post
    public function edit(Post $post){

        return view('post.edit',compact('post'));
    }
    //更新文章
    public function update(Post $post){
        //验证
        $this->validate(request(),[
           'title' => 'required|string|max:100|min:5',
            'content'=>'required|string|min:10'
        ]);
        //逻辑，更新
        $post->title = request('title');
        $post->content = request('content');
        $post->save();
        //渲染 详情页 with的参数1是一个session变量名，参数2为该session变量值，在视图直接这样获取
        return redirect("/posts/{$post->id}")->withSuccess('修改成功！');
    }
    //上传图片
    public function imageUpload(Request $request){
        //获取图片 保存到public下面，以加密的时间戳命名
        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
        //asset返回图片的地址
        return asset('storage/'.$path);
    }
    //删除文章
    public function delete(Post $post){
        $post->delete();
        return redirect('/posts');
    }
}
