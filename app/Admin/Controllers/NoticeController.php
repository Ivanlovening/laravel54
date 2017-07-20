<?php
namespace App\Admin\Controllers;

use App\Notice;

class NoticeController extends Controller{
    public function index(){
        $notices = Notice::all();
        return view('admin.notice.index',compact('notices'));
    }
    public function create(){

        return view('admin.notice.create');
    }

    public function store(){
        //验证
        $this->validate(request(),[
           'title'=>'required|max:50',
            'content'=>'required|max:1000'
        ]);
        //逻辑
        $notice = \App\Notice::create(request(['title','content']));
        //发送通知给每个
        dispatch(new \App\Jobs\SendMessage($notice));
        //渲染
        return redirect('/admin/notices');
    }

}