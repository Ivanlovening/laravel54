<?php
namespace App\Admin\Controllers;



class LoginController extends Controller
{
    public function welcome(){
        return redirect('/login');
    }
    //登录页
    public function index(){
        return view('admin.login.index');
    }
    //登录行为
    public function login(){
        //验证
        $this->validate(request(),[
           'name'=>'required|min:3|max:30',
            'password'=>'required|min:3|max:15'
        ]);
        //逻辑
        $user = request(['name','password']);
        if(\Auth::guard('admin')->attempt($user)){
            return redirect('/admin/index');
        }
        //渲染
        return \Redirect::back()->withErrors('用户名密码不匹配');
    }
    //登出行为
    public function logout(){
        \Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}