<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    //create可接受字段
    //protected $fillable=['name','password'];
    //因为user表中没有这个，为了避免报错，需要重写。
    protected $guarded=[];
    protected $rememberTokenName = '';
    //当前用户有哪些角色(多对多),并且取出中间表的user_id role_id数据。
    public function roles(){
        return $this->belongsToMany(\App\AdminRole::class,'admin_role_user','user_id','role_id')->withPivot(['user_id','role_id']);
    }
    //是否有某个角色,某些角色,跟用户所有角色做交集,双感叹号返回布尔值
    public function isInRoles($roles){
        return !! $roles->intersect($this->roles);
    }
    //给用户分配角色,找到用户所有角色再添加这个角色
    public function assignRole($role){
        return $this->roles()->save($role);
    }
    //删除用户的某个角色,找到用户所有角色然后移除这个角色
    public function deleteRole($role){
        return $this->roles()->detach($role);
    }
    //用户是否有某个权限,
    public function hasPremission($premission){

        //判断该用户是否拥有这个权限所对应的所有角色
        return $this->isInRoles($premission->roles);
    }
}
