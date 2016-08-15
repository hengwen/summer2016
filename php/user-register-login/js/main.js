$(function () {
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
});/**
 * Created by jason on 16/8/15.
 */
