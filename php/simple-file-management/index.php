<?php
    require "dir.func.php";
    require "file.func.php";
    require "common.func.php";
    $path = 'filetest';
    $path = isset($_REQUEST['path'])?$_REQUEST['path']:$path;
    $info = readDirection($path);
    $act = isset($_REQUEST['act'])?$_REQUEST['act']:"";
    echo $act;
    $filename = isset($_REQUEST['filename'])?$_REQUEST['filename']:"";
    $filepath = $path."/".$filename;
    $redirect = "index.php?path=$path";
//    if (!$info) {
//        showMsg("没有文件目录","index.php");
//    }
        if ($act == "创建文件") {
            $mes = createFile($filepath);
            showMsg($mes,$redirect);
        } elseif ($act == "showContent") {
            $content = file_get_contents($filepath);
           if (strlen($content)) {
               $newcontent = highlight_string($content,true);
                $str = <<<EOF
            <table width='100%' bgcolor='pink' cellpadding='5' cellspacing='0'>
                <tr>
                    <td>$content</td>
                </tr>
            </table>
EOF;
                echo $str;
           } else {
               showMsg("文件没有内容,请先编辑!",$redirect);
           }
        } elseif ($act == "editContent") {
            $content = file_get_contents($filepath);
            $str = <<<EOF
                <form action="index.php?act=doEdit" method="post">
                    <textarea name="newcontent" cols="190" rows="10">{$content}</textarea>
                    <input type="hidden" name="path" value="{$path}" />
                    <input type="hidden" name="filename" value="{$filename}"  />
                    <input type="submit" value="编辑" />
                </form>
EOF;
            echo $str;
        } elseif ($act == "doEdit") {
           $newcontent = $_REQUEST['newcontent'];
            $res = file_put_contents($filepath,$newcontent);
            if (false !== $res) {
                $msg = "编辑成功";
            } else {
                $msg = "编辑失败";
            }
            showMsg($msg,$redirect);
        } elseif ($act == "renameFile") {
            //显示重命名表单
            $str = <<<EOF
                <form action="index.php?act=doRename&path=$path&filename=$filename" method="post">
                    <label>请重命名文件: <input type="text" name="newname"/></label>
                    <input type="submit" value="重命名" />
                </form>
EOF;
            echo $str;
        } elseif ($act == "doRename") {
            //重命名文件操作
            $newname = $_REQUEST['newname'];
            $msg = renameFile($path,$filename,$newname);
            showMsg($msg,$redirect);
        } elseif ($act == "deleteFile") {
            //文件删除
            $msg = delFile($filepath);
            showMsg($msg,$redirect);
        } elseif ($act == "downloadFile") {
            //下载文件
            downloadFile($filepath);
        } elseif ($act == "创建文件夹") {
            $dirname = $_REQUEST['dirname'];
            $msg = createDir($path,$dirname);
            showMsg($msg,$redirect);
        } elseif ($act == "renameDir") {
            $oldDirName = $_REQUEST['dirname'];
            $str = <<<EOF
                <form action="index.php?act=doRenameDir&path=$path&oldDirName=$oldDirName" method="post">
                    新文件夹名称:
                    <input type="text" name="newDirName" />
                    <input type="submit" value="确定" />
                </form>
EOF;
            echo $str;
        } elseif ($act == "doRenameDir") {
            $oldDirName = $_REQUEST['oldDirName'];
            $newDirName = $_REQUEST['newDirName'];
            $msg = renameDirName($path,$oldDirName,$newDirName);
            showMsg($msg,$redirect);
        } elseif ($act == "showCopyDir") {
            $oldDirName = $_REQUEST['dirname'];
            $str = <<<EOF
                <form action="index.php?act=doCopyDir&path=$path&oldDirName=$oldDirName" method="post">
                    请输入目标文件夹路径:
                    <input type="text" name="dstDir" />
                    <input type="submit" value="确定" />
                </form>
EOF;
            echo $str;
        } elseif ($act == "doCopyDir") {
            $oldPath = $path."/".$_REQUEST['oldDirName'];
            $dstPath = $path."/".$_REQUEST['dstDir']."/".$_REQUEST['oldDirName'];
            $msg = doCopy($oldPath,$dstPath);
            showMsg($msg,$redirect);
        } elseif ($act == "delDir") {
            $dirPath = $path."/".$_REQUEST['dirname'];
            $msg = doDel($dirPath);
            showMsg($msg,$redirect);
        } elseif ($act == "cutDir") {
            $oldPath = $path ."/".$_REQUEST['dirname'];
            $str = <<<EOF
                <form action="index.php?act=doCutDir" method="post">
                    请输入剪切的目的位置:
                    <input type="text" name="newDirPath" />
                    <input type="hidden" name="oldpath" value="$oldPath"/>
                    <input type="submit" value="确定"/>
                </form>
EOF;
            echo $str;
        } elseif ($act == "doCutDir") {
            $oldPath = $_REQUEST['oldpath'];
            $newPath = $_REQUEST['newDirPath'];
            $msg = doCutDir($oldPath,$newPath);
            showMsg($msg,$redirect);
        } elseif ($act == "copyFile") {
            $oldFile = $path."/".$filename;
            $str = <<<EOF
                <form action="index.php?act=doCopyFile" method="post">
                    请输入复制目的位置:
                    <input type="text" name="newFile" />
                    <input type="hidden" name="oldFile" value="$oldFile" />
                    <input type="submit" value="确定" />
                </form>
EOF;
            echo $str;

        } elseif ($act == "doCopyFile") {
            $oldFile = $_REQUEST['oldFile'];
            $newFile = $_REQUEST['newFile'];
            $msg = doCopyFile($oldFile,$newFile);
            showMsg($msg,$redirect);
        } elseif ($act == "cutFile") {
            $oldFile = $path."/".$filename;
            $str = <<<EOF
                <form action="index.php?act=doCutFile" method="post">
                    请输入剪切目的位置:
                    <input type="text" name="newFile" />
                    <input type="hidden" name="oldFile" value="$oldFile" />
                    <input type="submit" value="确定" />
                </form>
EOF;
            echo $str;

        } elseif ($act == "doCutFile") {
            $oldFile = $_REQUEST['oldFile'];
            $newFile = $_REQUEST['newFile'];
            $msg = doCutFile($oldFile,$newFile);
            showMsg($msg,$redirect);
        } elseif ($act == "上传文件") {
            $fileInfo = $_FILES['myFile'];
//            var_dump($fileInfo);
            $msg = uploadFile($fileInfo,$path);
            showMsg($msg,$redirect);
        }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="cikonss.css" />
    <script src="jquery-ui/js/jquery-1.10.2.js"></script>
    <script src="jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
    <script src="jquery-ui/js/jquery-ui-1.10.4.custom.min.js"></script>
    <link rel="stylesheet" href="jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css"  type="text/css"/>
    <style>

        td{ text-align:center;}
        body,p,div,ul,ol,table,dl,dd,dt{
            margin:0;
            padding: 0;
        }
        a{
            text-decoration: none;
        }
        ul,li{
            list-style: none;
            float: left;
        }
        #top{
            width:100%;
            height:48px;
            margin:0 auto;
            background: #E2E2E2;
        }
        #navi a{
            display: block;
            width:48px;
            height: 48px;
        }
        #main{
            margin:0 auto;
            border:2px solid #ABCDEF;
        }
        .small{
            width:25px;
            height:25px;
            border:0;
        }

    </style>
    <script>
        function show(dis){
            document.getElementById(dis).style.display="block";
        }
        function showDetail(t,filepath){
            $("#showImg").attr("src",filepath);
            $("#showDetail").dialog({
                height:"auto",
                width:"auto",
                position:{my:"center",at:"center",collision:"fit"},
                modal:false,
                draggable:true,
                resizable:true,
                title:t,
                show:"slide",
                hide:"explode"
            });
        }
        function delConfirm(path,filename){
            if (window.confirm("您真的要删除这个文件吗?")) {
                window.location="index.php?act=deleteFile&path="+path+"&filename="+filename;
            }
        }
        function goBack(path){
            window.location.href = "index.php?path="+path;
        }
        function delDirConfirm(path,dirname){
            if (window.confirm("您真的要删除这个文件夹吗")) {
                window.location="index.php?act=delDir&path="+path+"&dirname="+dirname;
            }
        }
    </script>
</head>
<body>
<div id="showDetail" style="display:none;"><img src="" id="showImg" alt=""></div>
<h1>慕课网-在线文件管理器</h1>
<div id="top">
    <ul id="navi">
        <li><a href="index.php" title="主目录"><span style="margin-left: 8px; margin-top: 0px; top: 4px;" class="icon icon-small icon-square"><span class="icon-home"></span></span></a></li>
        <li><a href="#"  onclick="show('createFile')" title="新建文件" ><span style="margin-left: 8px; margin-top: 0px; top: 4px;" class="icon icon-small icon-square"><span class="icon-file"></span></span></a></li>
        <li><a href="#"  onclick="show('createFolder')" title="新建文件夹"><span style="margin-left: 8px; margin-top: 0px; top: 4px;" class="icon icon-small icon-square"><span class="icon-folder"></span></span></a></li>
        <li><a href="#" onclick="show('uploadFile')"title="上传文件"><span style="margin-left: 8px; margin-top: 0px; top: 4px;" class="icon icon-small icon-square"><span class="icon-upload"></span></span></a></li>
        <?php
        $back=($path=="filetest")?"filetest":dirname($path);
        ?>
        <li><a href="#" title="返回上级目录" onclick="goBack('<?php echo $back;?>')"><span style="margin-left: 8px; margin-top: 0px; top: 4px;" class="icon icon-small icon-square"><span class="icon-arrowLeft"></span></span></a></li>
    </ul>
</div>
<form action="index.php" method="post" enctype="multipart/form-data">
    <table width="100%" border="1" cellpadding="5" cellspacing="0">

        <tr id="createFolder"  style="display:none;">
            <td>请输入文件夹名称</td>
            <td >
                <input type="text" name="dirname" />
                <input type="hidden" name="path"  value="<?php echo $path;?>"/>
                <input type="submit" name="act"  value="创建文件夹"/>
            </td>
        </tr>
        <tr id="createFile"  style="display:none;">
            <td>请输入文件名称</td>
            <td >
                <input type="text"  name="filename" />
                <input type="hidden" name="path" value="<?php echo $path;?>"/>
                <input type="submit" name="act"  value="创建文件" />
            </td>
        </tr>
        <tr id="uploadFile" style="display:none;">
            <td >请选择要上传的文件</td>
            <td ><input type="file" name="myFile" />
                <input type="submit" name="act" value="上传文件" />
            </td>
        </tr>
        </tr>
        <tr>
            <td>编号</td>
            <td>名称</td>
            <td>类型</td>
            <td>大小</td>
            <td>可读</td>
            <td>可写</td>
            <td>可执行</td>
            <td>创建时间</td>
            <td>修改时间</td>
            <td>访问时间</td>
            <td>操作</td>
        </tr>

            <?php
            if (!$info) {
                echo "<tr><td colspan='11' height='300px;'>暂无数据!!</td></tr>";
            }
            $i=1;
            if (isset($info['file'])) {


                foreach ($info['file'] as $file)
                {
                    $filepath = $path."/".$file;
                    ?>
                    <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $file ?></td>
                    <td><?php $src = filetype($filepath)=="file" ? "file_ico.png" : "folder_ico.pnt";?>
                        <img src="images/<?php echo $src; ?>" alt="文件图标">
                    </td>
                    <td><?php echo transSize($filepath);?></td>
                    <td><?php $src = is_readable($filepath) ? "correct.png" : "error.png";?>
                        <img src="images/<?php echo $src; ?>" class="small"  alt="" >
                    </td>
                    <td><?php $src = is_writable($filepath) ? "correct.png" : "error.png";?>
                        <img src="images/<?php echo $src; ?>" class="small"  alt="" >
                    </td>
                    <td><?php $src = is_executable($filepath) ? "correct.png" : "error.png";?>
                        <img src="images/<?php echo $src; ?>" class="small"  alt="" >
                    </td>
                    <td><?php echo date('Y-m-d H:i:s',filectime($filepath));?></td>
                    <td><?php echo date('Y-m-d H:i:s',filemtime($filepath));?></td>
                    <td><?php echo date('Y-m-d H:i:s',fileatime($filepath));?></td>
                    <td>
                        <?php
                            $ext = explode(".",$file);
                            $ext = strtolower(end($ext));
                            $imgArr = array('gif','jpeg','jpg','png');
                            if (in_array($ext,$imgArr)) {
                                ?>
                                <a href="#" onclick="showDetail('<?php echo $file?>','<?php echo $filepath?>')"><img src="images/show.png" alt="查看" class="small" title="查看"></a>
                                <?php
                            } else {
                                ?>
                                <a href="index.php?act=showContent&path=<?php echo $path; ?>&filename=<?php echo $file;?>"><img src="images/show.png" class="small" alt="查看" title="查看"></a>
                            <?php
                            }
                        ?>
                        <a href="index.php?act=editContent&path=<?php echo $path?>&filename=<?php echo $file?>"><img src="images/edit.png" alt="编辑" class="small" title="编辑"></a>
                        <a href="index.php?act=renameFile&path=<?php echo $path?>&filename=<?php echo $file?>"><img src="images/rename.png" alt="重命名" class="small" title="重命名"></a>
                        <a href="index.php?act=copyFile&path=<?php echo $path?>&filename=<?php echo $file?>"><img src="images/copy.png" alt="复制" class="small" title="复制"></a>
                        <a href="index.php?act=cutFile&path=<?php echo $path?>&filename=<?php echo $file?>"><img src="images/cut.png"  alt="剪切" class="small" title="剪切"></a>
                        <a href="#" onclick="delConfirm('<?php echo $path?>','<?php echo $file?>')"><img src="images/delete.png" alt="删除" class="small" title="删除"></a>
                        <a href="index.php?act=downloadFile&path=<?php echo $path?>&filename=<?php echo $file?>"><img src="images/download.png" alt="下载" title="下载" class="small"></a>
                    </td>
                    </tr>
                    <?php
                $i++;
                }
            }
            ?>

             <?php
             if (isset($info['dir'])) {
            foreach ($info['dir'] as $dir)
            {
                $filepath = $path."/".$dir;
                ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $dir ?></td>
                    <td><?php $src = filetype($filepath)=="file" ? "file_ico.png" : "folder_ico.png";?>
                        <img src="images/<?php echo $src; ?>" alt="文件图标">
                    </td>
                    <td><?php $sum=0; echo getDirectionSize($filepath);?></td>
                    <td><?php $src = is_readable($filepath) ? "correct.png" : "error.png";?>
                        <img src="images/<?php echo $src; ?>" class="small"  alt="" >
                    </td>
                    <td><?php $src = is_writable($filepath) ? "correct.png" : "error.png";?>
                        <img src="images/<?php echo $src; ?>" class="small"  alt="" >
                    </td>
                    <td><?php $src = is_executable($filepath) ? "correct.png" : "error.png";?>
                        <img src="images/<?php echo $src; ?>" class="small"  alt="" >
                    </td>
                    <td><?php echo date('Y-m-d H:i:s',filectime($filepath));?></td>
                    <td><?php echo date('Y-m-d H:i:s',filemtime($filepath));?></td>
                    <td><?php echo date('Y-m-d H:i:s',fileatime($filepath));?></td>
                    <td>
                        <a href="index.php?path=<?php echo $filepath; ?>"><img src="images/show.png" class="small" alt="查看" title="查看"></a>
<!--                        <a href="index.php?act=editContent&path=--><?php //echo $path?><!--"><img src="images/edit.png" alt="编辑" class="small" title="编辑"></a>-->
                        <a href="index.php?act=renameDir&path=<?php echo $path?>&dirname=<?php echo $dir?>"><img src="images/rename.png" alt="重命名" class="small" title="重命名"></a>
                        <a href="index.php?act=showCopyDir&path=<?php echo $path?>&dirname=<?php echo $dir?>"><img src="images/copy.png" alt="复制" class="small" title="复制"></a>
                        <a href="index.php?act=cutDir&path=<?php echo $path?>&dirname=<?php echo $dir?>"><img src="images/cut.png"  alt="剪切" class="small" title="剪切"></a>
                        <a href="#" onclick="delDirConfirm('<?php echo $path?>','<?php echo $dir?>')"><img src="images/delete.png" alt="删除" class="small" title="删除"></a>
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
             ?>

    </table>
</form>
</body>
</html>