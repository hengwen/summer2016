<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/8/13
 * Time: 下午2:12
 */
session_start();
require "config.php";
require "PdoMysql.class.php";
$uId = $_SESSION['user_id'];
$pdo = new PdoMysql();
$result = $pdo->delete('imooc_pro_cart','uId='.$uId);
if ($result) {
    $respond = array(
        'status' => 1,
    );
} else {
    $respond = array(
        'status' => 0
    );
}
echo json_encode($respond);
