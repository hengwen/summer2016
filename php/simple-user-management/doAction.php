<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/8/7
 * Time: 下午7:14
 */
$mysqli = new mysqli('localhost','root','123456','test');
if ($mysqli->connect_errno) {
    die("Connect error:".$mysqli->connect_error);
}
$mysqli->set_charset('utf8');
$username = isset($_POST['username']) ? $mysqli->real_escape_string($_POST['username']) : "";
$password = isset($_POST['password']) ? md5($_POST['password']) : "";
$age  = isset($_POST['age']) ? $mysqli->real_escape_string($_POST['age']) : "";
$act = isset($_GET['act']) ? $mysqli->real_escape_string($_GET['act']) : "";
$id = isset($_GET['id']) ? $mysqli->real_escape_string($_GET['id']) : "";
switch ($act) {
    case "add":
        $sql = "insert into user(username,password,age) values('{$username}','{$password}','{$age}')";
        $res = $mysqli->query($sql);
        if ($res) {
            $insert_id = $mysqli->insert_id;
            echo "<script>alert('您是本站第{$insert_id}个用户');
                location.href='user.php';
            </script>";
        } else {
            echo "<script> 
                alert('添加失败');location.href='addUser.php';
            </script>";
        }
        break;
    case "delete":
        $sql = "delete from user where id = $id";
        $res = $mysqli->query($sql);
        if ($res) {
            echo "<script>
                alert('删除成功');location.href='user.php';
            </script>";
        } else {
            echo "<script>
                alert('删除失败');location.href='user.php';
            </script>";
        }
        break;
    case "edit":
        $sql = "update user set username='{$username}',password='{$password}',age='{$age}' where id = '{$id}'";
        $res = $mysqli->query($sql);
        if ($res) {
            echo "<script>
                alert('编辑成功');location.href='user.php';
            </script>";
        } else {
            echo "<script>
                alert('编辑成功');location.href='user.php';
            </script>";
        }
    break;
}