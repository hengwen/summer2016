<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/7/4
 * Time: 下午3:19
 */
function waterMark($waterSrc,$sourceImageSrc)
{
    $waterImageInfo = getimagesize($waterSrc);
    $waterWidth = $waterImageInfo[0];
    $waterHeight = $waterImageInfo[1];
    $type = image_type_to_extension($waterImageInfo[2],false);
    $func = 'imagecreatefrom'.$type;
    $waterImage = $func($waterSrc);

    $sourceImageInfo = getimagesize($sourceImageSrc);
    $sourceType = image_type_to_extension($sourceImageInfo[2],false);
    $func1 = 'imagecreatefrom'.$sourceType;
    $sourceImage = $func1($sourceImageSrc);
    imagecopymerge($sourceImage,$waterImage,20,20,0,0,$waterWidth,$waterHeight,50);
    header('Content-type:image/'.$sourceType);
    $func2 = 'image'.$sourceType;
    $func2($sourceImage);
    imagedestroy($waterImage);
    imagedestroy($sourceImage);
}
$waterSrc = 'images/image50/pic1.jpg';
$sourceImageSrc = 'images/pic0.jpg';
waterMark($waterSrc,$sourceImageSrc);