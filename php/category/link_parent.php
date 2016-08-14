<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Email: hengweno@163.com
 * Date: 16/8/14
 * Time: 下午1:00
 */
require "db.inc.php";

/**
 * 根据分类id按照层级获得所有父类,返回一维数组
 * @param $id
 * @param array $result
 * @return array
 */
function getLink($id,&$result=array())
{
    global $mysqli;
    $sql = "select pId,cateName from category_parent where id=$id";
    $res = $mysqli->query($sql);
    $row = $res->fetch_assoc();
    if ($row) {
        getLink($row['pId'],$result);
        $result[$id] = $row['cateName'];
    }

    return $result;
}

/**
 * 父分类与子分类以->符号构建父子关系,返回链接
 * @param $id
 * @param string $url
 * @return string
 */
function showLink($id,$url='show.php?cid=')
{
    $data = getLink($id);
    $link = '';
    foreach ($data as $key=>$value) {
        $link .= "<a href='{$url}{$key}'>$value</a>->";
    }
    $link = rtrim($link, '->');  //去除右边的->符号

    return $link;
}
//输出链接字符串
echo showLink(10);