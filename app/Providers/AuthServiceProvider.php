<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    //策略注册 给post模型创建的post策略类
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
        'App\Post' => 'App\Policies\PostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //给所有权限注册门卫
        //获取所有的权限，循环
        $premissions = \App\AdminPremission::all();
        foreach ($premissions as $premission){
            Gate::define($premission->name,function($user) use($premission){
               return $user->hasPremission($premission);
            });
        }
    }
}
