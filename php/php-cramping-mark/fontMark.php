<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/7/4
 * Time: 下午2:31
 */
function fontMark($src)
{
    $imageInfo = getimagesize($src);
    $type = image_type_to_extension($imageInfo[2],false);
    $pathArr = explode('/',$src);
    $fileName = end($pathArr);
    $func = 'imagecreatefrom'.$type;
    $sourceImage = $func($src);
    $fontColor = imagecolorallocatealpha($sourceImage,255,255,255,0.5);
    $fontFile = '/fonts/SIMYOU.TTF';
    $text = 'hello';
    imagettftext($sourceImage,14,15,50,50,$fontColor,$fontFile,$text);
    $path = 'images/fontmark/';
    if (!file_exists($path)) {
        mkdir($path,0777,true);
    }
    $func1 = 'image'.$type;
    $func1($sourceImage,$path.$fileName);
    header('Content-type:image/jpeg');
    $func1($sourceImage);
    imagedestroy($sourceImage);
}
$src = 'images/pic0.jpg';
fontMark($src);