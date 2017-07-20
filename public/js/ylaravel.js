//绕过token
$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    }
});

var editor = new wangEditor('content');
//图片上传地址，需要设置路由
if(editor.config){
    // 上传图片（举例）
    editor.config.uploadImgUrl = '/posts/img/upload';

    editor.config.uploadHeaders = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };
    // 隐藏掉插入网络图片功能。该配置，只有在你正确配置了图片上传功能之后才可用。
    editor.config.hideLinkImg = true;
    editor.create();
}
//更换头像，实时显示
$(".preview_input").change(function (event) {
    var file = event.currentTarget.files[0];
    var url = window.URL.createObjectURL(file);
    $(event.target).next(".preview_img").attr("src", url);
});
//关注与取消关注
$(".like-button").click(function(event){
   //获取触发事件的元素event.target
   var target = $(event.target);
   var current_like = target.attr('like-value');
   var user_id = target.attr('like-user');
   if(current_like==1){
       //取消关注
       $.ajax({
           url:"/user/"+user_id+'/unfan',
           method:'POST',
           dataType:'json',
           success:function(data){
               console.log(data);
               if(data.error!=0){
                   alert(data.msg);
                   return;
               }
               target.attr('like-value',0);
               target.text('关注');
           }
       });
   }else{
       //关注
       $.ajax({
           url:"/user/"+user_id+'/fan',
           method:'POST',
           dataType:'json',
           success:function(data){
               if(data.error!=0){
                   alert(data.msg);
                   return;
               }
               target.attr('like-value',1);
               target.text('取消关注');
           }
       });
   }
})





