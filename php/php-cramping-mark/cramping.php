<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/7/4
 * Time: 上午9:07
 */
//图片路径
$src = './images/pic0.jpg';
//$filename = end(explode('/',$src));
$path = explode('/',$src);
//获得文件名称
$filename = end($path);
//获得图片信息数组:
$imageInfo = getimagesize($src);
/*
Array([0] => 699
      [1] => 466
      [2] => 2
      [3] => width="699" height="466"
      [bits] => 8
      [channels] => 3
      [mime] => image/jpeg
)
 */

$width = $imageInfo[0];   //取得图片宽度
$height = $imageInfo[1];  //取得图片高度
$mime = $imageInfo['mime'];   // image/jpeg
$type = image_type_to_extension($imageInfo[2],false);   //jpeg  图片格式
//$type = image_type_to_extension($image[2],true);    //.jpeg
$image = imagecreatefromjpeg($src);  //创建图片资源
$cramping = imagecreatetruecolor(50,50);   //创建画布
imagecopyresampled($cramping,$image,0,0,0,0,50,50,$width,$height);
if (!file_exists('images/image50/')) {
    mkdir('images/image50/',0777,true);
}
imagejpeg($cramping,"images/image50/$filename");
header("Content-type:image/jpeg");
imagejpeg($cramping);
imagedestroy($image);


