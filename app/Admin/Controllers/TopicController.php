<?php
namespace App\Admin\Controllers;

use App\Topic;

class TopicController extends Controller{
    public function index(){
        $topics = Topic::all();
        return view('admin.topic.index',compact('topics'));
    }
    public function create(){
        return view('admin.topic.create');
    }

    public function store(){
        //验证
        $this->validate(request(),[
            'name' => 'required'
        ]);
        //逻辑
        Topic::create(['name'=>request('name')]);
        //渲染
        return redirect('/admin/topics');
    }
    public function destroy(Topic $topic){
        //要删除专题文章表

        $topic->delete();
        return [
            'error'=>0,
            'msg'=>''
        ];
    }
}