<?php
/**
 * 转换文件大小,使用单位表示。
 * @param $file
 * @return string
 */
function transSize($file)
{
    $arr = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'EB');  //定义单位数组
    $i = 0;  //对应数组$arr中的下标,初始为Bytes
    $size = filesize($file);  //获得文件大小
    while ($size > 1024) {  //文件大小超过本身单位级别
        $size /= 1024;
        $i++;   //单位增加一个单位级别
    }
    $fileSize = round($size, 2).$arr[$i];  //表刘两位有效数字,并拼接上单位
    return $fileSize;
}

/**
 * 创建新文件
 * @param $filename
 * @return string
 */
function createFile($filename)
{
    //验证文件名是否合法,是否包含非法字符/,*,<,>,?,|
    $pattern = "/[\/\*<>\?\|]/";
    if(!preg_match($pattern,basename($filename))) {
        //检查当前目录下是否存在同名文件
        if (!file_exists($filename)) {
            //使用touch函数创建文件
            if(touch($filename)) {
                return "文件创建成功";
            } else {
                return "文件创建失败";
            }
        } else {
            return "文件已存在,请重新命名";
        }
    } else {
        return "非法文件名";
    }
}

/**
 * 文件重命名操作
 * @param $path
 * @param $oldname
 * @param $newname
 * @return string
 */
function renameFile($path,$oldname,$newname)
{
    $oldPath = $path."/".$oldname;
    $newPath = $path."/".$newname;
    if (checkFileName($newname)) {
        if (!file_exists($path."/".$newname)) {
            if (rename($oldPath,$newPath)) {
                $msg =  "重命名成功";
            } else {
                $msg = "重命名失败";
            }
        } else {
            $msg = "存在同名文件,请重新命名!";
        }
    } else {
        $msg = "非法文件名,请重新命名!";
    }
    return $msg;
}

/**
 * 检查文件名合法性
 * @param $filename
 * @return bool
 */
function checkFileName($filename)
{
    $pattern = "/[\/\*<>\?\|]/";
    if(preg_match($pattern,$filename)) {
        return false;
    } else {
        return true;
    }
}

/**
 * 文件删除操作
 * @param $filepath
 * @return string
 */
function delFile($filepath)
{
    if (unlink($filepath)) {
        return "文件删除成功";
    }
    return "文件删除失败";
}

/**
 * 下载文件
 * @string $filepath
 */
function downloadFile($filepath)
{
    header("Content-Disposition:attachment;filename=".basename($filepath));
    header('content-length:'.filesize($filepath));
    readfile($filepath);
//    return "下载成功";
}

/**
 * 复制文件
 * @string
 * $oldFile
 * @string $newFile
 * @return string
 */
function doCopyFile($oldFile,$newFile)
{
    if (!file_exists($newFile)) {
        if (copy($oldFile,$newFile)) {
            $msg = "复制成功";
        } else {
            $msg = "复制失败";
        }
    } else {
        $msg = "存在同名文件";
    }

    return $msg;
}


/**
 * 剪切文件
 * @string
 * $oldFile
 * @string $newFile
 * @return string
 */
function doCutFile($oldFile,$newFile)
{
    if (!file_exists($newFile)) {
        if (rename($oldFile,$newFile)) {
            $msg = "剪切成功";
        } else {
            $msg = "剪切失败";
        }
    } else {
        $msg = "存在同名文件";
    }

    return $msg;
}

function uploadFile($fileInfo,$path,$allow=array('jpg','jpeg','gif','png','txt','doc','docx'))
{
    //判断文件上传是否成功,为0或者UPLOAD_ERR_OK表示上传成功
    if ($fileInfo['error'] == UPLOAD_ERR_OK) {
        //判断是否是通过HTTP上传的
//        $nameArr = explode('.',$fileInfo['name']);
//        $ext = end($nameArr);
        $ext = strtolower(pathinfo($fileInfo['name'],PATHINFO_EXTENSION));
        $unique = getUnique();
        $distination = $path."/".pathinfo($fileInfo['name'],PATHINFO_FILENAME)."_".$unique.".".$ext;
        if (is_uploaded_file($fileInfo['tmp_name'])) {
            if (in_array($ext,$allow)) {
                if (move_uploaded_file($fileInfo['tmp_name'],$distination)) {
                    $msg = "文件上传成功";
                } else {
                    $msg = "文件上传失败";
                }
            } else {
                $msg = "非法文件类型";
            }
        } else {
            $msg = "文件不是通过HTTP上传的";
        }
    } else {
        switch($fileInfo['error']) {
            case 1:
                $msg = "超过配置文件允许大小";
                break;
            case 2:
                $msg = "超过表单允许文件大小";
                break;
            case 3:
                $msg = "文件部分上传";
                break;
            case 4:
                $msg = "没有文件被上传";

        }
    }

    return $msg;
}


