<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class RegisterController extends Controller
{
    //
    public function index(){
        return view('register.index');
    }
    public function register(){
        //验证
//        $this->validate(request(),[
//            'name' =>'required|string|max:20|min:5|unique:users,name',
//            'email'=>'required|string|email|unique:users,email',
//            'password'=>'required|confirmed'
//        ]);
        $validator = \Validator::make(request()->Input(),[
            'name' =>'required|max:20|min:3|unique:users,name',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:5|max:10|confirmed'
        ]);
        //逻辑
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $name = request('name');
        $email = request('email');
        $password = bcrypt(request('password'));
        $user = User::create(compact('name','email','password'));
        //渲染

        return redirect('/login');
    }
}
