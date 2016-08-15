<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Email: hengweno@163.com
 * Date: 16/8/15
 * Time: 下午12:33
 */
require 'config.php';
require 'PdoMysql.class.php';

$msg = array();
/**
 * 验证用户名
 */
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    if (empty($username)) {
        $msg['username'] = "用户名不能为空";
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/",$username)) {
        $msg['username'] = "用户名格式不正确";
    } else {
        $pdo = new PdoMysql();
        $res = $pdo->find('user', 'username="' . $username . '"', 'id');
        if ($res)
        {
            $msg['username'] = "用户名已存在";
        }
    }
}
/**
 * 验证邮箱
 */
if (isset($_POST['email'])) {
   if (empty($_POST['email'])) {
       $msg['email'] = "邮箱不能为空";
   } elseif (!filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL)) {
       $msg['email'] = "邮箱格式不正确";
   }
}
/**
 * 响应ajax请求
 */
if (count($msg)) {
    echo json_encode(array('status'=>0,'msg'=>$msg));
} else {
    echo json_encode(array('status'=>1));
}

