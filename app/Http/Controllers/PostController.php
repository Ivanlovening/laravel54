<?php

namespace App\Http\Controllers;
use App\Comment;
use App\Post;
use App\Zan;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //文章列表页
    public function index(){
        //获取文章，所有
        $posts = Post::orderBy('created_at','desc')->withCount(['comments','zans'])->with('user')->paginate(6);
        //两种预加载方式with 或者load ,提前拿出关联关系
        //$posts->load('user');
        return view('post.index',compact('posts'));
    }
    //文章详情
    public function show(Post $post){
        //预加载，加载与文章关联的评论，等同于把该篇文章的所有评论找出来放到它的comments属性下面
        $post->load('comments');
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
        //获取当前登录用户的id
        $user_id = \Auth::id();
        $params = array_merge(request(['title','content']),compact('user_id'));
//        dd($params);
        //添加成功，返回
        $post = Post::create($params);
        return redirect('/posts');
    }
    //编辑文章Post $post
    public function edit(Post $post){

        return view('post.edit',compact('post'));
    }
    //更新文章
    public function update(Post $post){
        //验证
//        $this->validate(request(),[
//           'title' => 'required|string|max:100|min:5',
//            'content'=>'required|string|min:10'
//        ]);
        $validator = \Validator::make(request()->input(),[
            'title'=>'required|max:100|min:5',
            'content'=>'required|min:10'
        ],[
            'required'=>':attribute为必填项',
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
        };
        //逻辑，更新
        //权限判断
        $this->authorize('update',$post);

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
        //权限判断
        $this->authorize('delete',$post);
        $post->delete();
        return redirect('/posts');
    }
    //评论
    public function comment(Post $post){
        //验证
        $this->validate(request(),[
            'content' => 'required|min:3'
        ]);
        //逻辑
        $comment = new Comment();
        $comment->user_id = \Auth::id();
        $comment->content = request('content');
        //保存,文章id就不用写了，$post里有
        $post->comments()->save($comment);
        //渲染
        return back();
    }
    //点赞
    public function zan(Post $post){
        //要存入赞表的数据
        $param = [
            'user_id'=>\Auth::id(),
            'post_id'=>$post->id
        ];
        Zan::firstOrCreate($param);
        return back();
    }
    //取消赞
    public function unzan(Post $post){
        $post->zan(\Auth::id())->delete();
        return back();
    }
    /*
    //搜索
    public function search(){
        //验证
        $this->validate(request(),[
            'query' => 'required',
        ]);
        //逻辑
        $query = request('query');
        //搜索获取满足条件的所有文章，并且分页
        $posts = \App\Post::search($query)->paginate(2);
        //渲染
        return view('post.search',compact('query','posts'));
    }*/
}
