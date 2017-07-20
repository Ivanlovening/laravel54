<?php
namespace App\Admin\Controllers;

use App\AdminUser;

class UserController extends Controller{
    public function index(){
        $users = AdminUser::paginate(6);
        return view('admin.user.index',compact('users'));
    }
    public function create(){
        return view('admin.user.create');
    }
    public function store(){
        //验证
        $this->validate(request(),[
           'name' => 'required|min:5',
            'password' => 'required',
        ]);
        //逻辑
        $name = request('name');
        $password = bcrypt(request('password'));
        //变成一个数组插入数据库
        AdminUser::create(compact('name','password'));
        //渲染
        return redirect('admin/users');
    }
    //编辑
    public function edit(AdminUser $user){
        return view('admin.user.edit',compact('user'));
    }
    public function update(AdminUser $user){
        $this->validate(request(),[
            'name' => 'required|min:5'
        ]);
        if(empty(request('password'))){
            $user->password = bcrypt(request('password'));
        }
        $user->name = request('name');
        $user->save();
        return redirect('admin/users');
    }
    //删除
    public function delete(AdminUser $user){

        $user->delete();
        return redirect('admin/users');
    }
    //用户角色
    public function role(AdminUser $user){
        $roles = \App\AdminRole::all();
        $myRoles = $user->roles;
        return view('admin.user.role',compact('roles','myRoles','user'));
    }
    //储存用户角色
    public function storeRole(AdminUser $user){
        $this->validate(request(),[
            'roles' => 'required|array'
        ]);
        //把接受到的数组转换为一个对像
        $roles = \App\AdminRole::findMany(request('roles'));
        $myRoles = $user->roles;
        dd($user->roles);
        //有增加，计算差集合 大的->diff(小的)，属于前面的，不属于后面的元素
        $addRoles = $roles->diff($myRoles);
        foreach ($addRoles as $role){
            $user->assignRole($role);
        }
        //有删除的，计算差集
        $deleteRoles = $myRoles->diff($roles);
        foreach ($deleteRoles as $role){
            $user->deleteRole($role);
        }
        return redirect('/admin/users');

    }
}