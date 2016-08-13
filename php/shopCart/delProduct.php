<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/8/13
 * Time: 下午1:54
 */
session_start();
require "config.php";
require "PdoMysql.class.php";
$uId = $_SESSION['user_id'];
$pId = intval($_POST['pId']);
$pdo = new PdoMysql();
$result = $pdo->delete('imooc_pro_cart','uId='.$uId.' and '.'pId='.$pId);
$sql = "select sum(price*num) total from imooc_pro_cart where uId=".$uId;
$result1 = $pdo->getRow($sql);
if ($result) {
    $respond = array(
        'status' => 1,
        'msg' => $result1['total']
    );
} else {
    $respond = array(
        'status' => 0
    );
}
echo json_encode($respond);