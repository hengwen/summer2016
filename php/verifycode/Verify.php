<?php

/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/7/3
 * Time: 下午2:26
 */

/**
 * Class Verify
 * 生成随机验证码,类型可以为数字(type=1)、字母(type=2)、数字字母组合(type=3)、中文(type=4)、图片(type=5)
 */
class Verify
{
    private $chars;  //随机验证码内容
    private $length = 4;  //验证码长度
    private $image;   //画布
    private $line = 5;   //干扰线
    private $pixel = 20;   //干扰点
    private $type;    //验证码类型
    private $width;  //画布宽度
    private $height = 30;  //画布高度
    private $fontfile = './fonts/SIMYOU.TTF';

    public function  __construct($type=1)
    {
        $this->type = $type;
        $this->getVerify();
    }

    /**
     * 生成随机数字、字母、数字字母组合
     * @param int $type
     * @param int $length
     * @return string
     */
    private function buildRandomString()
    {
        $chars = '';
        if ($this->type == 1) {  //数字
            $chars = join('',range(0,9));
        } elseif ($this->type == 2) {  //大小写字母
            $chars = join('',array_merge(range('a','z'),range('A','Z')));
        } elseif ($this->type == 3) {  //大小写子母和数字
            $chars = join('',array_merge(range('a','z'),range('A','Z'),range(0,9)));
        }
        if ($this->length > strlen($chars)) {
            echo '字符串长度不够!';
        } else {
            $chars = str_shuffle($chars);  //打乱字符串
            $chars = substr($chars,0,$this->length);  //截取$length长度的字符串
        }

        return $chars;
    }
    /**
     * 生成$length长度的随机中文
     * @param $length
     * @return string
     */
    private function buildRandomChinese()
    {
        $chinese = '的一是在了不和有大这主中人上为们地个用工时要动国产以我到他会作来分生对于学下级就年阶义发成部民可出能方进同行面传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低';
        $chineseArr = str_split($chinese,3);  //数组
//        var_dump(count($chineseArr));
        if ($this->length > count($chineseArr)) {
            echo '字符串长度不够';
        } else {
            for ($i = 0; $i < $this->length; $i++) {
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
    private function addLine()
    {
        $color = imagecolorallocate($this->image,mt_rand(120,200),mt_rand(120,200),mt_rand(120,200));
        if ($this->line) {
            for ($i = 0; $i < $this->line; $i++) {
                imageline($this->image,mt_rand(0,$this->width-2),mt_rand(0,$this->height-2),mt_rand(0,$this->width-2),mt_rand(0,$this->height-2),$color);
            }
        }
    }

    /**
     * 生成干扰点
     * @param $pixel
     * @param $image
     */
    private function addPixel()
    {
        $color = imagecolorallocate($this->image,mt_rand(120,200),mt_rand(120,200),mt_rand(120,200));
        if ($this->pixel) {
            for ($i = 0; $i < $this->pixel; $i++) {
                imagesetpixel($this->image,mt_rand(1,$this->width-2),mt_rand(1,$this->height-2),$color);
            }
        }

    }
    /**
     * 生成图片验证码
     */
    private function verifyImage()
    {
        $picture = array(0=>'猫',1=>'兔',2=>'狗',3=>'鸟');
        $num = mt_rand(0,3);
        $this->chars = $picture[$num];
        $filename = './images/pic'.$num.'.jpg';
        $content = file_get_contents($filename);
        header("Content-type:image/jpg");
        echo $content;
    }

    /**
     * 生成画布
     * @param $width
     * @param $height
     */
    private function buildImage()
    {
        $this->image = imagecreatetruecolor($this->width,$this->height);
        $white = imagecolorallocate($this->image,255,255,255);
        imagefilledrectangle($this->image,1,1,$this->width-2,$this->height-2,$white);
    }

    /**
     * 填充画布的内容
     */
    private function fillStringContent()
    {
        //获得随机字符串并填充到画布中
        for ($i = 0; $i < $this->length; $i++) {
            $size = mt_rand(14,18);
            $x = $i*20+4;
            $y = mt_rand(18,26);
            $angle = mt_rand(-15,15);
            $color = imagecolorallocate($this->image,mt_rand(0,120),mt_rand(0,120),mt_rand(0,180));
            $text = substr($this->chars,$i,1);
            imagettftext($this->image,$size,$angle,$x,$y,$color,$this->fontfile,$text);
        }
    }
    /**
     * 填充画布的内容
     */
    private function fillChineseContent()
    {
        //获得随机字符串并填充到画布中
        for ($i = 0; $i < $this->length; $i++) {
            $size = mt_rand(12,14);
            $x = $i*25+4;
            $y = mt_rand(18,25);
            $angle = mt_rand(-15,15);
            $color = imagecolorallocate($this->image,mt_rand(0,120),mt_rand(0,120),mt_rand(0,180));
            $text = $this->chars[$i];
            imagettftext($this->image,$size,$angle,$x,$y,$color,$this->fontfile,$text);
        }
    }

    /**
     * 生成验证码图片并销毁图像资源
     */
    private function showVerify()
    {
        $this->addLine();
        $this->addPixel();
        header("Content-type:image/gif");
        imagegif($this->image);
        imagedestroy($this->image);
    }

    /**
     *根据类型显示验证码
     */
    public function getVerify()
    {
        if ($this->type == 1 || $this->type == 2 || $this->type == 3) {
            $this->width= $this->length*20;
            $this->chars = $this->buildRandomString();
            $this->buildImage();
            $this->fillStringContent();
            $this->showVerify();
        } elseif($this->type == 4) {
            $this->width= $this->length*25;
            $this->chars = $this->buildRandomChinese();
            $this->buildImage();
            $this->fillChineseContent();
            $this->showVerify();
        } elseif ($this->type == 5) {
            $this->verifyImage();
        }
    }

    /**
     * 返回验证码值,以便使用session验证
     * @return $chars
     */
    public function getChars()
    {
        return $this->chars;
    }

}