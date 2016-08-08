<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <?php
    $mysqli = new mysqli('localhost','root','123456','test');
    if ($mysqli->connect_errno) {
        die("Connect error:".$mysqli->connect_error);
    }
    $mysqli->set_charset('utf8');
    $sql = "select id,username,age from user";
    $mysqli_result = $mysqli->query($sql);
    if ($mysqli_result && $mysqli_result->num_rows > 0) {
        $rows = $mysqli_result->fetch_all(MYSQLI_ASSOC);
    }
    ?>
    <h2>用户管理 <a href="addUser.php">添加</a> </h2>
    <table border="1" cellpadding="0" cellspacing="0" width="400px" bgcolor="#f1f1f1" style="font-size:18px; text-align:center;">
        <tr>
            <td>编号</td>
            <td>用户名</td>
            <td>年龄</td>
            <td>操作</td>
        </tr>
        <?php $i=1; foreach($rows as $row): ?>
            <tr>
                <td><?php echo $i?></td>
                <td><?php echo $row['username']?></td>
                <td><?php echo $row['age']?></td>
                <td><a href="editUser.php?id=<?php echo $row['id']?>">编辑</a> | <a href="doAction.php?act=delete&id=<?php echo $row['id']?>">删除</a> </td>
            </tr>
        <?php $i++; endforeach ?>
    </table>
</body>
</html>
