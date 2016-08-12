<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/8/12
 * Time: 上午11:43
 */
/**
 * 页面跳转
 * @string $msg
 * @string $msg1
 * @string $url
 */
function redirect($msg,$msg1,$url)
{
    echo "$msg<br>";
    echo "3秒后跳转到$msg1<br>";
    echo "<meta http-equiv='refresh' content='3;url={$url}'/>";
}