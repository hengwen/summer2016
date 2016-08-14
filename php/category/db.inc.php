<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Email: hengweno@163.com
 * Date: 16/8/14
 * Time: 上午10:54
 */
$mysqli = new mysqli('localhost','root','123456','imooc');
if ($mysqli->connect_errno) {
    echo "Connect Error:".$mysqli->connect_error;
}
$mysqli->set_charset('utf8');
