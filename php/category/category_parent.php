<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Email: hengweno@163.com
 * Date: 16/8/14
 * Time: 上午10:57
 */
require "db.inc.php";
/**
 * 获得并分级构建分类,并返回一维数组
 * @param int $pId
 * @param array $result
 * @param int $num
 * @return array
 */
function getList($pId,&$result=array(),$num=-1)
{
    //定义分类名称前输出几个--|分割符号
    $num = $num +1;
    //使用全局变量$mysqli
    global $mysqli;
    $sql = "select id,cateName from category_parent where pId=$pId";
    $res = $mysqli->query($sql);
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            //构建子分类前输出层级数($num)个分割符号
            $row['cateName'] = str_repeat('|--',$num) . $row['cateName'];
            //保存分类id和名称
            $result[$row['id']] = $row['cateName'];
            //递归调用getList()如果有子类则将子类保存到$result数组中
            getList($row['id'],$result,$num);
        }
    }

    return $result;
}


/**
 * 将分类一下拉列表显示
 * @param int $id
 */
function showList($id=0)
{
    $listArr = getList($id);
    echo "<select name='cateId'>";
    foreach ($listArr as $key=>$list) {
        echo "<option value='$key'>";
        echo  $list;
        echo "</option>";
    }
    echo "</select>";
}

//调用并显示
showList();