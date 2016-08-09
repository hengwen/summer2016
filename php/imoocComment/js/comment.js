$(document).ready(function(){
    //标志用于防止表单多次提交,若值为false则可以提交,若值为true则表单正在提交
    var flag = false;
    $("#commnent-form").submit(function(e){
        //阻止表单自动提交
        e.preventDefault();
        //如果flag标志为真表示表单正在提交
        if(flag) return false;
        flag = true;
        $("#submit").val("发布。。。");
        //serialize()函数序列化表单的内容为字符串
        $.post("doAction.php",$(this).serialize(),function (msg) {
            flag = false;
            $('#submit').val("发布评论");
            if (msg.status) {
                $(msg.html).hide().insertBefore("#commnent-form").slideDown();
                $('#contentVal').val('');
            }else{
                $.each(msg.errors,function (k, v) {
                    $('#'+k).append("<span class='error'>"+v+"</span>");
                });
            }
        },"json");

    });
});/**
 * Created by jason on 16/8/9.
 */
