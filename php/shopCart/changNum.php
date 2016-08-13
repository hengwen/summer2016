<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/8/13
 * Time: 下午1:13
 */
session_start();
require "config.php";
require "PdoMysql.class.php";
$num = intval($_POST['num']);
$pId = intval($_POST['pId']);
$uId = $_SESSION['user_id'];
$pdo = new PdoMysql();
$where = 'pId='.$pId.' and '.'uId='.$uId;
$result = $pdo->update('imooc_pro_cart',array('num'=>$num),$where);
$sql = "select sum(price*num) total from imooc_pro_cart where uId=".$uId;
$result1 = $pdo->getRow($sql);
if ($result) {
    $respond = array(
        'status'=>1,
        'msg' => $result1['total']
    );
} else {
    $respond = array(
        'status'=>0,
        'msg'=>'修改失败'
    );
}
echo json_encode($respond);