<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/7/3
 * Time: 上午11:29
 */
session_start();
$code = $_POST['verifycode'];
if (strtolower($code) == strtolower($_SESSION['verifycode'])) {
    echo '验证成功';
} else {
    echo '验证失败';
}
