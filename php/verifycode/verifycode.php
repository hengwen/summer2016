<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/7/3
 * Time: 上午8:19
 */
session_start();
/*
 * 生成随机字符串
 */
function buildRandomString($type=1,$length=4)
{
    if ($type == 1) {  //数字
        $chars = join('',range(0,9));
    } elseif ($type == 2) {  //大小写字母
        $chars = join('',array_merge(range('a','z'),range('A','Z')));
    } elseif ($type == 3) {  //大小写子母和数字
        $chars = join('',array_merge(range('a','z'),range('A','Z'),range(0,9)));
    }
//    switch ($type) {
//        case 1:
//            $chars = join('',range(0,9));
//            break;
//        case 2:
//            $chars = join('',array_merge(range('a','z'),range('A','Z')));
//            break;
//        case 3:
//            $chars = join('',array_merge(range('a','z'),range('A','Z'),range(0,9)));
//    }
    if ($length > strlen($chars)) {
        echo '字符串长度不够';
    } else {
        $chars = str_shuffle($chars);  //打乱字符串
        $chars = substr($chars,0,$length);  //截取$length长度的字符串
    }

   return $chars;
}

/**
 * 生成$length长度的随机中文
 * @param $length
 * @return string
 */
function buildRandomCn($length)
{
    $chinese = '的一是在了不和有大这主中人上为们地个用工时要动国产以我到他会作来分生对于学下级就年阶义发成部民可出能方进同行面传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低';
    $chineseArr = str_split($chinese,3);  //数组
    $chars = array();
    if ($length > count($chineseArr)) {
        echo '字符串长度不够';
    } else {
        for ($i = 0; $i < $length; $i++) {
            $index = mt_rand(0,count($chineseArr)-1);
            $chars[] = $chineseArr[$index];
        }
    }
    return $chars;
}

/**
 * 生成干扰直线
 * @param $line
 * @param $image
 */
function addLine($line,$image)
{
    $color = imagecolorallocate($image,mt_rand(120,200),mt_rand(120,200),mt_rand(120,200));
    if ($line) {
        for ($i = 0; $i < $line; $i++) {
            imageline($image,mt_rand(0,80),mt_rand(0,40),mt_rand(0,80),mt_rand(0,40),$color);
        }
    }
}

/**
 * 生成干扰点
 * @param $pixel
 * @param $image
 */
function addPixel($pixel,$image)
{
    $color = imagecolorallocate($image,mt_rand(120,200),mt_rand(120,200),mt_rand(120,200));
    if ($pixel) {
        for ($i = 0; $i < $pixel; $i++) {
            imagesetpixel($image,mt_rand(1,79),mt_rand(1,39),$color);
        }
    }

}

function capchCn()
{
    $image = imagecreatetruecolor(100,35);
    $white = imagecolorallocate($image,255,255,255);
    imagefilledrectangle($image,1,1,98,33,$white);
    $chars = buildRandomCn(4);
    $_SESSION['verifycode'] = $chars;
    //获得随机字符串并填充到画布中
    for ($i = 0; $i < count($chars); $i++) {
        $size = mt_rand(13,15);
        $x = $i*25+4;
        $y = mt_rand(20,30);
        $angle = mt_rand(-15,15);
        $color = imagecolorallocate($image,mt_rand(0,120),mt_rand(0,120),mt_rand(0,180));
        $fontfile = './fonts/SIMYOU.TTF';
        $text = $chars[$i];
        imagettftext($image,$size,$angle,$x,$y,$color,$fontfile,$text);
    }
    addLine(5,$image);
    addPixel(20,$image);
    header("Content-type:image/gif");
    imagegif($image);
    imagedestroy($image);
}

/**
 * 生成图片验证码
 */
function captchImage()
{
    $picture = array(0=>'猫',1=>'兔',2=>'狗',3=>'鸟');
    $num = mt_rand(0,3);
    $value = $picture[$num];
    $_SESSION['verifycode'] = $value;
    $filename = './images/pic'.$num.'.jpg';
    $content = file_get_contents($filename);
    header("Content-type:image/jpg");
    echo $content;
}

/**
 * 生成数字,字母组合的验证码图片
 */
function verifyImage()
{
    $image = imagecreatetruecolor(80,30);
    $white = imagecolorallocate($image,255,255,255);
    imagefilledrectangle($image,1,1,78,28,$white);
    $chars = buildRandomString(4,4);
    $_SESSION['verifycode'] = $chars;
    //获得随机字符串并填充到画布中
    for ($i = 0; $i < strlen($chars); $i++) {
        $size = mt_rand(14,18);
        $x = $i*20+4;
        $y = mt_rand(18,26);
        $angle = mt_rand(-15,15);
        $color = imagecolorallocate($image,mt_rand(0,120),mt_rand(0,120),mt_rand(0,180));
        $fontfile = './fonts/SIMYOU.TTF';
        $text = substr($chars,$i,1);
        imagettftext($image,$size,$angle,$x,$y,$color,$fontfile,$text);
    }
    addLine(5,$image);
    addPixel(20,$image);
    header("Content-type:image/gif");
    imagegif($image);
    imagedestroy($image);
}
//verifyImage();
//captchImage();
capchCn();