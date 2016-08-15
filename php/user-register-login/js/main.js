$(function () {
    /**
     * 登录表单验证
     */
    $('#form-login').submit(function (e) {
        e.preventDefault();
            $.post('doAction.php?act=login',$(this).serialize(),function (data) {
                if (data.status == 0) {
                    $('#error').html(data.msg);
                } else {
                    window.location.href = "admin.php";
                }
            },'json');


    });
    var flag = false;
    /**
     * 整个注册表单验证
     */
    $('#form-reg').submit(function (e) {
        e.preventDefault();
        if (flag) return false;
        flag = true;
        $.post('doAction.php?act=reg',$(this).serialize(),function (data) {
            flag = false;
            $('.error').html('');
            if (data.status == 0) {
                $.each(data.msg,function (i, item) {
                    $("input[name='"+i+"'] ~ span").html(item);
                    $('#passwordsignup').val('');
                })
            }
        },'json');
    })
    /**
     * 注册表单用户名input验证
     */
    $('#usernamesignup').blur(function () {
        // console.log($(this).val());
        $.post('validate.php',{'username':$(this).val()},function (data) {
            // $('.error').html('');
            if (data.status== 0) {
                $.each(data.msg,function (i,item) {
                    $("input[name='"+i+"'] ~ span").html(item);
                });
            } else {
                $("input[name='username'] ~ span").html('');
            }
        },'json');
    });
    /**
     * 注册表单邮箱input验证
     */
    $('#emailsignup').blur(function () {
        // console.log($(this).val());
        $.post('validate.php',{'email':$(this).val()},function (data) {
            // $('.error').html('');
            if (data.status == 0) {
                $.each(data.msg,function (i,item) {
                    $("input[name='"+i+"'] ~ span").html(item);
                });
            } else {
                $("input[name='email'] ~ span").html('');
            }
        },'json');
    });
});/**
 * Created by jason on 16/8/15.
 */
