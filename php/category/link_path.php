<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Email: hengweno@163.com
 * Date: 16/8/14
 * Time: 下午2:56
 */

require "db.inc.php";

/**
 * 根据分类id获得所有父分类。
 * @param $id
 * @return mixed
 */
function link_path($id)
{
    global $mysqli;
    //获得子分类的全路径
    $sql = "select concat(path,',',id) as fullPath from category_path where id=$id";
    $res = $mysqli->query($sql);
    $row = $res->fetch_assoc();
    //根据全路径获得父分类
    $sql1 = "select id,cateName from category_path where id in ({$row['fullPath']}) order by id asc";
    $res1 = $mysqli->query($sql1);
    while ($row = $res1->fetch_assoc()) {
        $result[ $row['id'] ] = $row['cateName'];
    }

    return $result;
}

/**
 * 构建分类导航
 * @param $id
 * @param string $url
 * @return string
 */
function show_link($id,$url='show.php?cid=')
{
    $data = link_path($id);
    $link = '';
    foreach ($data as $key=>$value) {
        $link .= "<a href='{$url}{$key}'>$value</a>->";
    }
    $link = rtrim($link, '->');  //去除右边的->符号

    return $link;
}
echo password_hash('huanghengwen',PASSWORD_DEFAULT);
echo show_link(10);


