<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/8/1
 * Time: 下午5:48
 */
function showMsg($msg,$url)
{
    echo "<script type='text/javascript'>alert('{$msg}');window.location='{$url}';</script>";
}

function getUnique($length=10)
{
    $unique = substr(md5(uniqid(microtime(true),true)),0,$length);
    return $unique;
}
