<?php
 session_start();
 if (!isset($_SESSION['user_id'])) {
     echo "<meta http-equiv='refresh' content='index.php?act=login#tologin' />";
     exit;
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <h3>欢迎您 <?php echo $_SESSION['user_name'] ?> <a href="doAction.php?act=logout">退出</a> </h3>
</body>
</html>