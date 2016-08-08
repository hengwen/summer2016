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
    $id = $_GET['id'];
    $sql = "select username,password,age from user WHERE id={$id}";
    $res = $mysqli->query($sql);
    if ($res && $res->num_rows > 0) {
        $result = $res->fetch_assoc();
    }

?>
<legend>编辑用户</legend>
<form action="doAction.php?act=edit&id=<?php echo $id ?>" method="post" >
    <table border="1" cellspacing="0" cellpadding="0" bgcolor="#f0ffff" width="500">
        <tr>
            <td>用户名:</td>
            <td><input type="text" name="username" value="<?php echo $result['username']?>"></td>
        </tr>
        <tr>
            <td>密码:</td>
            <td><input type="password" name="password"></td>
        </tr>
        <tr>
            <td>年龄:</td>
            <td><input type="number" name="age" min="1" max="125" value="<?php echo $result['age'] ?>"></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="编辑"></td>
        </tr>
    </table>
</form>
</body>
</html>
