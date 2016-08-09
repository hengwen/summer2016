<?php
    require "connect.php";
    require "Comment.class.php";
    //查找数据库中的所有用户评论
    $sql = "select username,face,email,url,content,pubTime from comments";
    $mysqli_result = $mysqli->query($sql);
    if ($mysqli_result && $mysqli_result->num_rows > 0) {
        //循环遍历每条评论,并实例化为一个Comment对象
        while ($row = $mysqli_result->fetch_assoc()) {
            $comments[] = new Comment($row);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>慕课网评论系统</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

    <section class="wrap">
        <h2>慕课网评论系统练习</h2>
        <?php
        if ($comments) {
            //如果存在comments变量则循环调用对象的output方法输出评论
            foreach($comments as $comment) {
                echo $comment->output();
            }
        }
        ?>
        <form action="" method="post" class="comment-form" id="commnent-form">
            <div id="username">
                <label>昵称<br/>
                    <input type="text" name="username" placeholder="请输入您的昵称" required>
                </label>
            </div>
            <div id="face">
                头像<br/>
                <div class="face">
                <label>
                    <input type="radio" name="face" value="1" required>
                    <img src="img/1.jpg" alt="用户头像" width="50" height="50" >
                </label>
                <label>
                    <input type="radio" name="face" value="2">
                    <img src="img/2.jpg" alt="用户头像" width="50" height="50" >
                </label>
                <label>
                    <input type="radio" name="face" value="3">
                    <img src="img/3.jpg" alt="用户头像" width="50" height="50" >
                </label>
                <label>
                    <input type="radio" name="face" value="4">
                    <img src="img/4.jpg" alt="用户头像" width="50" height="50" >
                </label>
                </div>
            </div>
            <div id="email">
                <label>邮箱:<br>
                    <input type="email" name="email" placeholder="请输入您的邮箱地址" id="" required>
                </label>
            </div>
            <div id="url">
                <label>个人博客<br>
                    <input type="url" name="url" required  id="">
                </label>
            </div>
            <div id="content">
                <label>评论内容<br>
                    <textarea name="content" id="contentVal" rows="8" cols="30" placeholder="请输入您的评论" ></textarea>
                </label>
            </div>
            <input type="submit" value="发布评论" id="submit">
        </form>
    </section>
    <script src="js/jquery.min.js"></script>
    <script src="js/comment.js"></script>
</body>
</html>