<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function welcome(){
        return redirect('/login');
    }
    public function index(){
        //如果用户登录就跳转到首页
        if(\Auth::check()){
           return redirect('/posts');
        }
        return view('login.index');
    }

    public function login(){
        //验证
        $this->validate(request(),[
            'email' => 'required|email',
            'password' => 'required|min:5|max:10',
            'is_remember'=>'integer'
        ]);
        //逻辑
        $user = request(['email','password']);
        $is_remember = boolValue(request('is_remember'));
        //邮箱密码验证
        if(\Auth::attempt($user,$is_remember)){
            return redirect('/posts');
        }
        //渲染
        return \Redirect::back()->withErrors('邮箱密码不匹配');
    }

    public function logout(){
        \Auth::logout();
        return redirect('/login');
    }
}
