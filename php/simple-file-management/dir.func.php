<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/8/1
 * Time: 下午2:56
 */

/**
 * 遍历目录返回文件中的所有文件和目录名称,并保存在二维数组中
 * @param $path
 * @return array
 */
function readDirection($path)
{
    $dir = opendir($path);  //打开目录
    $arr = array(); //存放遍历文件夹结果
    //遍历所有文件和目录
    while (($item = readdir($dir)) !== false){
        if ($item != "." && $item != ".."){  //不遍历.和..两个特殊目录
            if (is_file($path . "/" . $item)){  //如果是文件则保存在$arr['file']中
                $arr['file'][] = $item;
            }
            if (is_dir($path . "/" . $item)){  //如果是目录则保存在$arr['dir']中
                $arr['dir'][] = $item;
            }
        }
    }
    closedir($dir);
    return $arr;
}

/**
 * 遍历获得文件大小
 * @string $path
 * @return int
 */
function getDirectionSize($path)
{
    $sum = 0;
    global $sum;
    $dir = opendir($path);
    while (($item=readdir($dir)) !== false) {
        if ($item !="." && $item !="..") {
            if (is_file($path."/".$item)) {
                $sum+=filesize($path."/".$item);
            }
            if (is_dir($path."/".$item)) {
                $func = __FUNCTION__;
                $func($path."/".$item);
            }
        }
    }
    closedir($dir);
    return transDirSize($sum);
}

/**
 * 转换目录大小
 * @param $size
 * @return string
 */
function transDirSize($size)
{
    $arr = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'EB');  //定义单位数组
    $i = 0;  //对应数组$arr中的下标,初始为Bytes
    while ($size > 1024) {  //文件大小超过本身单位级别
        $size /= 1024;
        $i++;   //单位增加一个单位级别
    }
    $DirSize = round($size, 2).$arr[$i];  //表刘两位有效数字,并拼接上单位
    return $DirSize;
}

function createDir($path,$dirname) {
    $dirPath = $path."/".$dirname;
    if (!file_exists($dirPath)) {
        if (mkdir($dirPath)) {
            $msg = "文件创建成功!";
        } else {
            $msg = "文件创建失败";
        }
    } else{
        $msg = "文件夹已经存在,请重新命名!";
    }

    return $msg;
}

/**
 * 重命名文件夹
 * @param $path
 * @param $oldDirname
 * @param $newDirName
 */
function renameDirName($path,$oldDirname,$newDirName)
{
    $oldDir = $path."/".$oldDirname;
    $newDir = $path."/".$newDirName;
    if (!file_exists($newDir)) {
        if (rename($oldDir,$newDir)) {
            $msg = "重命名成功!";
        } else {
            $msg = "重命名失败!";
        }
    } else {
        $msg = "已存在同名文件夹!";
    }

    return $msg;
}

/**
 * 复制文件夹
 * @string $source
 * @string $dst
 * @return string
 */
function doCopy($source,$dst)
{
    if(!file_exists($dst)) {
        mkdir($dst,0777,true);
    }
    $info = opendir($source);
    while(($item=readdir($info)) !== false) {
        if ($item!="."&&$item!="..") {
            $path = $source."/".$item;
            if (is_file($path)) {
                copy($path,$dst."/".$item);
            }
            if (is_dir($path)) {
                $func = __FUNCTION__;
                $func($path,$dst."/".$item);
            }
        }
    }
    closedir($info);
    return "文件夹复制成功!";
}

/**
 * 删除文件夹
 * @string $path
 * @return string
 */
function doDel($path)
{
    $info = opendir($path);
    while (($item=readdir($info)) !== false) {
        if($item!="."&&$item!="..") {
            $fullPath = $path."/".$item;
            if (is_file($fullPath)) {
                unlink($fullPath);
            }
            if (is_dir($fullPath)) {
                $func = __FUNCTION__;
                $func($fullPath);
            }
        }

    }
    rmdir($path);
    closedir($info);
    return "文件夹删除成功";
}

function doCutDir($oldPath,$newPath)
{
//    if (!file_exists($newPath)) {
//        mkdir($newPath,0777,true);
//    }
    if (!file_exists($newPath)) {
        if (!rename($oldPath,$newPath)) {
           $msg = "剪切失败";
        } else {
            $msg = "剪切成功";
        }

    } else {
        $msg = "存在同名文件!";
    }

    return $msg;
}
