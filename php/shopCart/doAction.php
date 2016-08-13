<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/8/13
 * Time: 上午9:51
 */
session_start();
require "config.php";
require "PdoMysql.class.php";
$pId = intval($_POST['pid']);
$num = intval($_POST['num']);
$uId = $_SESSION['user_id'];
$pdo = new PdoMysql();
//查询购物车表中是否已经有该用户的购买该商品记录
$where = 'pId='.$pId.' and uId='.$uId;
$sql = "select * from imooc_pro_cart where ".$where;
$result = $pdo->getRow($sql);
if (!$result) { //如果没有记录,则执行添加操作
    //获得要插入购物车表的数组
    $price = $pdo->findById('imooc_pro',$pId,'iPrice')['iPrice'];
    $createTime = time();
    $data = compact('pId','uId','num','price','createTime');
    $res = $pdo->add($data,'imooc_pro_cart');
} else { //如果有记录,则执行更新商品数量操作
    $pNum = $result['num'] + $num;
    $data = array('num'=>$pNum);
    $res = $pdo->update('imooc_pro_cart',$data,$where);
}

if ($res) {  //添加成功
    $response = array(
        'status' => 1,
        'msg' => '添加成功',
    );
} else { //失败
    $response = array(
        'status' => 0,
        'msg' => '添加失败'
    );
}
echo json_encode($response);




