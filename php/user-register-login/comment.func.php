<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/8/12
 * Time: 上午11:43
 */
/**
 * 页面跳转
 * @string $msg
 * @string $msg1
 * @string $url
 */
function redirect($msg,$msg1,$url)
{
    echo "$msg<br>";
    echo "3秒后跳转到$msg1<br>";
    echo "<meta http-equiv='refresh' content='3;url={$url}'/>";
}

/**
 * 整个注册表单验证
 * @param $data
 * @return array
 */
function validate($data) {
    $msg = array();
    //验证用户名
    if (empty($data['username'])) {
        $msg['username'] =  "用户名不能为空";
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/",$data['username'])) {
        $msg['username'] =  "用户名只能由字母和数字组成";
    } else {
        $pdo = new PdoMysql();
        $res = $pdo->find('user','username="'.$data['username'].'"','id');
        if ($res) {
            $msg['username'] =  "用户名已存在";
        }
    }
    //验证邮箱
    if (empty($data['email'])) {
        $msg['email'] =  "邮箱不能为空";
    } elseif (!filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL)) {
        $msg['email'] =  "邮箱格式不正确";
    }
    return $msg;
}