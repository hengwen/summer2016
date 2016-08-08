<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <legend>添加用户</legend>
    <form action="doAction.php?act=add" method="post" >
        <table border="1" cellspacing="0" cellpadding="0" bgcolor="#f0ffff" width="500">
            <tr>
                <td>用户名:</td>
                <td><input type="text" name="username" placeholder="请输入用户名"></td>
            </tr>
            <tr>
                <td>密码:</td>
                <td><input type="password" name="password" ></td>
            </tr>
            <tr>
                <td>年龄:</td>
                <td><input type="number" name="age" min="1" max="125" placeholder="请输入合法年龄"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="添加"></td>
            </tr>
        </table>
    </form>
</body>
</html>
