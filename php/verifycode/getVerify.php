<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/7/3
 * Time: 下午3:38
 */
session_start();
require './Verify.php';
$verify = new Verify(4);
$_SESSION['verifycode'] = $verify->getChars();