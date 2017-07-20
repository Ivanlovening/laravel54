<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //个人设置
    public function setting(){
        return view('user.setting');
    }
    public function settingStore(Request $request,User $user){
        $user = \Auth::user();
        //验证,
        $this->validate(request(),[
           'name' => 'required|min:3|max:20'
        ]);
        $name = request('name');
        if($name != $user->name){
            if(User::where('name',$name)->count()>0){
                return back()->withErrors('用户名已经存在了，请重新修改');
            }
            $user->name = $name;
        }
        //逻辑
        /*头像*/
        if(!empty(request('avatar'))){
            $path = request('avatar')->storePublicly(md5($user->id.time()));
            $user->avatar = '/storage/'.$path;
        }
        //渲染
        $user->save();
        return redirect('/posts');
    }
    //个人中心
    public function show(User $user){
        //个人信息以及包括文章数，粉丝数，关注数
        $user = User::withCount(['posts','fans','stars'])->find($user->id);
        //文章列表,分页
        $posts = $user->posts()->orderBy('created_at','desc')->paginate(3);
        //关注的明星，包括粉丝数，文章数，关注数
        $stars = $user->stars();
        $susers = User::whereIn('id',$stars->pluck('star_id'))->withCount(['posts','fans','stars'])->get();
        //被那些人关注（粉丝），包括文章数，粉丝数，关注数
        $fans = $user->fans();
        $fusers = User::whereIn('id',$fans->pluck('fan_id'))->withCount(['posts','fans','stars'])->get();
        return view('user.show',compact('user','posts','susers','fusers'));
    }
    //
    public function fan(User $user){
//        获取当前用户
        $me = \Auth::user();
        $me->doFan($user->id);
        return [
            'error' => 0,
            'message' => ''
        ];
    }
    //取消
    public function unfan(User $user){
        $me = \Auth::user();
        $me->doUnFan($user->id);
        return [
            'error' => 0,
            'message' => ''
        ];
    }
}
