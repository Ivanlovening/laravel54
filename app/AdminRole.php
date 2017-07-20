<?php

namespace App;

use App\Model;

class AdminRole extends Model
{
    //对应的表
    protected $table = 'admin_roles';
    //当前角色所有的权限多对多
    public function premissions(){
        return $this->belongsToMany(\App\AdminPremission::class,'admin_premission_role','role_id','premission_id')->withPivot(['role_id','premission_id']);
    }
    //给角色授予权限
    public function grantPremission($premission){
        return $this->premissions()->save($premission);
    }
    //取消角色的权限,从所有权限中移除
    public function deletePremission($premission){
        return $this->premissions()->detach($premission);
    }
    //角色是否有这个权限，这些权限  ,跟它的所有权限求交集
    public function hasPremission($premission){
        return $this->premissions->contains($premission);
    }
}
