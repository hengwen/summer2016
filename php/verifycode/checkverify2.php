<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/7/3
 * Time: 下午2:19
 */
session_start();
$code = str_split($_POST['verifycode'],3);
if ($code == $_SESSION['verifycode']) {
    echo '验证成功';
} else {
    echo '验证失败';
}