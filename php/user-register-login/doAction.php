<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/8/12
 * Time: 上午9:03
 */
session_start();
require "config.php";
require "PdoMysql.class.php";
require "swiftmailer-master/lib/swift_required.php";
require "comment.func.php";
require "pwd.php";
//接收数据
$act = $_GET['act'];
$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';  //使用反斜线引用字符串:单引号,双引号,反斜线,null
$password = isset($_POST['password']) ? md5($_POST['password']) : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$table = 'user';
//建立数据库连接
$PdoMysql = new PdoMySQL();
if ($act === 'reg') {  //注册操作
    $token = md5($username.$password.$email);
    $regtime = time();
    $token_exptime = $regtime + 24*3600;  //激活码过期时间是注册一天后
    //使用变量创建数组,键名为变量名称,值为变量值
    $data = compact('username','password','email','token','token_exptime','status','regtime');
    $res = $PdoMysql->add($data,$table);  //插入成功返回所影响记录条数,否则返回false
    //如果注册成功(插入)则发送邮件
    if ($res) {
        //获得最后插入的auto_increment值
        $lastInsertId = $PdoMysql->getLastInsertId();
        //获得传输对象
        $transport = Swift_SmtpTransport::newInstance('smtp.163.com',25);
        //设置账号和密码
        $transport->setUsername('hengweno@163.com');
        $transport->setPassword($emailPassword);
        //得到发送邮件对象Swift_Mailer
        $mailer = Swift_Mailer::newInstance($transport);
        //得到邮件信息对象
        $message = Swift_Message::newInstance();
        //设置发送者信息
        $message->setFrom(array('hengweno@163.com'=>'hengwen'));
        //设置接收者信息
        $message->setTo(array($email=>'jason'));
        //设置邮件主题
        $message->setSubject("激活邮件");
        //设置邮件内容
        $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?act=active&token={$token}";
        $urlEncode = urlencode($url);
        $str = <<<EOF
            亲爱的{$username}您好!感谢您注册我们的网站<br>
            请点击此链接激活账号后即可登录网站<br>
            <a href="{$url}">{$urlEncode}</a><br>
            如果点击链接没有响应,可以将连接复制到浏览器地址栏中执行,激活有效时间为24小时
EOF;
        $message->setBody($str,'text/html','utf-8');
        //发送邮件
        try{ 
            if ($mailer->send($message)) {   //发送成功
                redirect("恭喜您{$username}注册成功,请登录邮箱激活后登录!","登录页面","index.php#tologin");
            } else {  //发送失败
                $PdoMysql->delete($table,"id = '{$lastInsertId}'");
                redirect("邮件发送失败,请重新注册!","注册页面","index.php#toregister");
            }
        } catch (Swift_SwiftException $e) {
            echo "邮件发送错误:".$e->getMessage();
        }

    } else { //插入失败,跳转到注册页面
        redirect("注册失败!","注册页面","index.php#toregister");
    }
} elseif ($act === 'login') {   //登录操作
    $res = $PdoMysql->find($table,"username='{$username}' and password='{$password}'",'status,id,username');
    if ($res) {
        if (is_numeric($res['status']) && $res['status'] == 0) {  //未激活
//            redirect("请先激活后,再登录!","登录页面","index.php#tologin");
            $respond = array('status' => 0,'msg'=> '用户未激活,请先激活');
        } else {
//            echo "<meta http-equiv='refresh' content='3;url=http://shop.com' />";
            $_SESSION['user_id'] = $res['id'];
            $_SESSION['user_name'] = $res['username'];
//            redirect("登录成功!","首页","admin.php");
            $respond = array('status' => 1,'msg' => '登录成功!');
        }
    } else {
        $respond = array('status' => 0,'msg' => '用户名或密码错误');
//        redirect("用户名或密码错误!","登录页面","index.php#tologin");
    }
    echo json_encode($respond);
} elseif ($act === 'active') {  //激活操作
    $token = addslashes($_GET['token']);
    $row = $PdoMysql->find($table,"token='{$token}'","id,status,token_exptime");
    if ($row) {
        if (is_numeric($row['status']) && $row['status'] == 0) {
            $now = time();  //获得当前时间
            if ($now > $row['token_exptime']) {  //如果当前时间大于过期时间
                $PdoMysql->delete($table,"id = {$row['id']}");
                redirect("激活码已经过期,请重新注册","注册页面","index.php?act=reg#toregister");
            } else {
                $res = $PdoMysql->update($table,array('status'=>1),"id={$row['id']}");
                if ($res) {
                    redirect("激活成功!","登录页面","index.php#tologin");
                } else {
                    redirect("激活失败!","注册页面","index.php?act=reg#toregister");
                }
            }
        } elseif ($row['status'] === 1) {
            redirect("邮箱已经激活!","登录页面","index.php#tologin");
        }
    } else {
        echo "fail";
    }
} elseif ($act === "logout") {
    $_SESSION = null;
    session_destroy();
    redirect("退出成功!","登录页面","index.php#tologin");
}
















