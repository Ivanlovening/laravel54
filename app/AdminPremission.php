<?php

namespace App;

use App\Model;

class AdminPremission extends Model
{
    //对应的表
    protected $table='admin_premissions';
    //权限属于那个角色（多对多）
    public function roles(){
        return $this->belongsToMany(\App\AdminRole::class,'admin_premission_role','premission_id','role_id')->withPivot(['premission_id','role_id']);
    }
    //
}
