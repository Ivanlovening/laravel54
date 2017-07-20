<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('/',function (){
//    return '欢迎啊';
//});

//路由是有先后顺序的，先把最符合要求的放前面
/*********用户模块***************/
Route::get('/', '\App\Http\Controllers\LoginController@welcome' );
//注册页面
Route::get('/register','\App\Http\Controllers\RegisterController@index');
//注册行为
Route::post('/register','\App\Http\Controllers\RegisterController@register');
//登录页面
Route::get('/login','\App\Http\Controllers\LoginController@index');
//登录行为
Route::post('/login','\App\Http\Controllers\LoginController@login');
//登出行为
Route::get('/logout','\App\Http\Controllers\LoginController@logout');


/*************文章模块**************/
Route::group(['middleware'=>'auth:web'],function(){
    //搜索
    Route::get('/posts/search','\App\Http\Controllers\PostController@search');
    //文章列表页
    Route::get('/posts','\App\Http\Controllers\PostController@index');
    //创建文章
    Route::get('/posts/create','\App\Http\Controllers\PostController@create');
    //post提交表单，保存文章信息
    Route::post('/posts','\App\Http\Controllers\PostController@store');
    //文章详情页
    Route::get('/posts/{post}','\App\Http\Controllers\PostController@show');
    //编辑文章
    Route::get('/posts/{post}/edit','\App\Http\Controllers\PostController@edit');
    //编辑后表单提交保存文章
    Route::put('/posts/{post}','\App\Http\Controllers\PostController@update');
    //删除文章
    Route::get('/posts/{post}/delete','\App\Http\Controllers\PostController@delete');
    //图片上传
    Route::post('/posts/image/upload','\App\Http\Controllers\PostController@imageUpload');
    //评论提交路由
    Route::post('/posts/{post}/comment','\App\Http\Controllers\PostController@comment');
    //点赞
    Route::get('/posts/{post}/zan','\App\Http\Controllers\PostController@zan');
    //取消赞
    Route::get('/posts/{post}/unzan','\App\Http\Controllers\PostController@unzan');
    //个人中心
    Route::get('/user/{user}','\App\Http\Controllers\UserController@show');
    Route::post('/user/{user}/fan','\App\Http\Controllers\UserController@fan');
    Route::post('/user/{user}/unfan','\App\Http\Controllers\UserController@unfan');
    //个人设置页面
    Route::get('/user/me/setting','\App\Http\Controllers\UserController@setting');
    //个人设置操作
    Route::put('/user/me/settingStore','\App\Http\Controllers\UserController@settingStore');
    //专题详情页
    Route::get('/topic/{topic}','\App\Http\Controllers\TopicController@show');
    //投稿
    Route::post('/topic/{topic}/submit','\App\Http\Controllers\TopicController@submit');
    //通知
    Route::get('/notices','\App\Http\Controllers\NoticeController@index');
    //用户删除通知
    Route::get('/notices/{notice}/delete','\App\Http\Controllers\NoticeController@delete');
});

//后台
/********后台管理路由*********/
Route::group(['prefix'=>'admin'],function(){
    Route::get('/', '\App\Admin\Controllers\LoginController@welcome');
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

