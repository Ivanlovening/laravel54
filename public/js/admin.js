$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    }
});
//ajax审核文章
$(".post-audit").click(function(event){
    //获取当前点击的元素

    target = $(event.target);

    var post_id = target.attr('post-id');
    var status = target.attr('post-action-status');
    $.ajax({
        url:"/admin/posts/"+post_id+"/status",
        type:"POST",
        data:{'status':status},
        dataType:"json",
        success:function(data){
            if(data.error!=0){
                alert(data.msg);
                return;
            }
            target.parent().parent().remove();
        }
    })

})
//ajax删除专题
$(".resource-delete").click(function(event){
    if(confirm('你确认执行删除操作吗？')==false){
        return;
    }
    target = $(event.target);
    event.preventDefault();
    var url = $(target).attr('delete-url');

    $.ajax({
       url:url,
       method:"POST",
       data:{'_method':'DELETE'},
        dataType:"json",
        success:function(data){
           if(data.error!=0){
               alert(data.msg);
               return;
           }
           //当前页重新加载
           target.parent().parent().remove();
        }

    });
})