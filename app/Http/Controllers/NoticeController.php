<?php
namespace App\Http\Controllers;

use App\Notice;

class NoticeController extends Controller{
    public function index(){
        //获取当前用户模型
        $user = \Auth::user();
        //获取他所有的通知
        $notices = $user->notices;
        return view('notice.index',compact('notices'));
    }
    public function delete(Notice $notice){
        $user = \Auth::user();
        //删除通知
        $user->deleteNotice($notice);
        return redirect('/notices');
    }
}