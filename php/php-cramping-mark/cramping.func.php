<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/7/4
 * Time: 上午11:43
 */
function cramping($src,$width,$height)
{
    $imageInfo = getimagesize($src);
    $sourceWidth = $imageInfo[0];
    $sourceHeight = $imageInfo[1];
    $sourceMime = $imageInfo['mime'];
    $type = image_type_to_extension($imageInfo[2],false);
    $pathArr = explode('/',$src);
    $filename = end($pathArr);
    $func = 'imagecreatefrom'.$type;
    $sourceImage = $func($src);
    $distImage = imagecreatetruecolor($width,$height);
    imagecopyresampled($distImage,$sourceImage,0,0,0,0,$width,$height,$sourceWidth,$sourceHeight);
    $func1 = 'image'.$type;
    $savePath = 'images/image'.$width.'/';
    if (!file_exists($savePath)) {
        mkdir($savePath,0777,true);
    }
    $func1($distImage,$savePath.$filename);
    header('Content-type:'.$sourceMime);
    $func1($distImage);
    imagedestroy($sourceImage);
}
$src = 'images/pic1.jpg';
cramping($src,50,50);

