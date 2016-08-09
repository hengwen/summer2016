<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/8/9
 * Time: 上午8:56
 */
require "connect.php";
require "Comment.class.php";
$arr = array();
$res = Comment::validate($arr);
if ($res) { //过滤成功,向数据库中插入数据,并相应ajax请求
    $arr['pubTime'] = time();
    $sql = "insert into comments(username,face,email,url,content,pubTime) values(?,?,?,?,?,?)";
    $mysqli_stmt = $mysqli->prepare($sql);
    $mysqli_stmt->bind_param('sisssi',$arr['username'],$arr['face'],$arr['email'],$arr['url'],$arr['content'],$arr['pubTime']);
    $result = $mysqli_stmt->execute();
    $comment = new Comment($arr);
    echo json_encode(array('status'=>1,'html'=>$comment->output()));
} else { //表单过滤有错误,响应ajax请求
    echo json_encode(array('status'=>0,'errors'=>$arr));
}
