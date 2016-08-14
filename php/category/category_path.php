<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Email: hengweno@163.com
 * Date: 16/8/14
 * Time: 下午1:51
 */
require "db.inc.php";

/**
 * 获得表现层级关系的分类一维数组
 * @return mixed
 */
function category_path()
{
    global $mysqli;
    $sql = "select id,cateName,concat(path,',',id) as fullPath from category_path order by fullPath";
    $res = $mysqli->query($sql);
    while ($row = $res->fetch_assoc()) {
        //获得分割符号的数量
        $num = count(explode(',',trim($row['fullPath'],',')))-1;
        $row['cateName'] = str_repeat('|--',$num).$row['cateName'];
        $result[ $row['id'] ] = $row['cateName'];
    }

    return $result;
}

/**
 * 一下拉列表展示分类
 */
function show_category()
{
    $cates = category_path();
    echo "<select name='cateId'>";
    foreach ($cates as $key=>$list) {
        echo "<option value='$key'>";
        echo  $list;
        echo "</option>";
    }
    echo "</select>";
}

show_category();