<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/8/9
 * Time: 上午11:31
 */
$mysqli = new mysqli('localhost','root','123456','imoocComment');
if ($mysqli->connect_errno) {
    echo "Connect error:".$mysqli->connect_error;
}
$mysqli->set_charset('utf8');