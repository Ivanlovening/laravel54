<?php
/********后台管理路由*********/
Route::group(['prefix'=>'admin'],function(){
    Route::get('/', function(){ return redirect('/login'); });
    //登录登出
    Route::get('/login','\App\Admin\Controllers\LoginController@index');
    Route::post('/login','\App\Admin\Controllers\LoginController@login');
    Route::get('/logout','\App\Admin\Controllers\LoginController@logout');
    //后台首页

    //auth+guard,自己定义的

    //需要登录才能访问的页面都放在这个组里面
    Route::group(['middleware'=>'auth:admin'],function(){
        Route::get('/index','\App\Admin\Controllers\HomeController@index');
        Route::group(['middleware'=>'can:system'],function(){
            /****************************用户***********************************/
            //管理员页面
            Route::get('/users','\App\Admin\Controllers\UserController@index');
            //添加管理员
            Route::get('/users/create','\App\Admin\Controllers\UserController@create');
            //保存
            Route::post('/users/store','\App\Admin\Controllers\UserController@store');
            //修改页面
            Route::get('/users/{user}/edit','\App\Admin\Controllers\UserController@edit');
            Route::put('/users/{user}/update','\App\Admin\Controllers\UserController@update');
            //删除
            Route::get('/users/{user}/delete','\App\Admin\Controllers\UserController@delete');
            //用户角色关联
            Route::get('/users/{user}/role','\App\Admin\Controllers\UserController@role');
            Route::post('/users/{user}/role','\App\Admin\Controllers\UserController@storeRole');
            /*********************************角色***************************************/
            Route::get('/roles','\App\Admin\Controllers\RoleController@index');
            Route::get('/roles/create','\App\Admin\Controllers\RoleController@create');
            Route::post('/roles/store','\App\Admin\Controllers\RoleController@store');

//            Route::get('/roles/{role}/edit','\App\Admin\Controllers\RoleController@edit');
//            Route::put('/roles/{role}/update','\App\Admin\Controllers\RoleController@update');
//            Route::get('/roles/{role}/delete','\App\Admin\Controllers\RoleController@delete');
            //角色和权限
            Route::get('/roles/{role}/premission',                                                                '\App\Admin\Controllers\RoleController@premission');
            Route::post('/roles/{role}/premission',                                                              '\App\Admin\Controllers\RoleController@storePremission');
            /**********************************权限*****************************************/
            Route::get('/premissions','\App\Admin\Controllers\PremissionController@index');
            Route::get('/premissions/create',                                                                                   '\App\Admin\Controllers\PremissionController@create');
            Route::post('/premissions/store',                                                                                     '\App\Admin\Controllers\PremissionController@store');
        });

        Route::group(['middleware'=>'can:post'],function(){
            /*********************************文章管理**************************************/
            Route::get('/posts','\App\Admin\Controllers\PostController@index');
            Route::get('/posts/{post}','\App\Admin\Controllers\PostController@show');
            Route::post('/posts/{post}/status','\App\Admin\Controllers\PostController@status');
        });
        /*专题管理*/
        //用资源路由，制定总共有多少种方法，每种路由对应默认相应方法
        Route::group(['middleware'=>'can:topic'],function(){
            Route::resource('topics','\App\Admin\Controllers\TopicController',['only'=>['index','create','store','destroy']]);
        });
        /*通知管理*/
        Route::group(['middleware'=>'can:notice'],function(){
            Route::resource('notices','\App\Admin\Controllers\NoticeController',['only'=>['index','create','store']]);
        });
    });
});