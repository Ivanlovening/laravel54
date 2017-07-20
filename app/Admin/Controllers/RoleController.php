<?php
namespace App\Admin\Controllers;

use App\AdminRole;

class RoleController extends Controller{
    public function index(){
        $roles = AdminRole::paginate(10);
        return view('admin.role.index',compact('roles'));
    }
    //创建角色
    public function create(){
        return view('admin.role.create');
    }
    //储存角色
    public function store(AdminRole $role){
        $this->validate(request(),[
            'name'=>'required|min:3',
            'description'=>'required'
        ]);
        AdminRole::create(request(['name','description']));
        return redirect('/admin/roles');
    }
    //角色权限
    public function premission(AdminRole $role){
        //获取所有的权限
        //获取角色权限
        $premissions = \App\AdminPremission::all();
        $myPremissions = $role->premissions;
        return view('admin.role.premission',compact('premissions','myPremissions','role'));
    }

    public function storePremission(AdminRole $role){
        $this->validate(request(),[
            'premissions' => 'required|array'
        ]);
        $premissions = \App\AdminPremission::findMany(request('premissions'));
        $myPremissions = $role->premissions;
        //增加的
        $addPremissions = $premissions->diff($myPremissions);
        foreach ($addPremissions as $addPremission){
            $role->grantPremission($addPremission);
        }
        //删除的
        $deletePremissions = $myPremissions->diff($premissions);
        foreach ($deletePremissions as $deletePremission){
            $role->deletePremission($deletePremission);
        }
        return redirect('/admin/roles');

    }
}