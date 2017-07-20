<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //mb4string 4个字节对应一个字符
        //初始化，默认字符串最大长度为767/4=191个字节
        Schema::defaultStringLength(191);
        //专题列表共享
        \View::composer('layout.sidebar',function($view){
            $topics = \App\Topic::all();//所有专题
            $view->with('topics',$topics);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
