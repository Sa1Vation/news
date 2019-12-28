<?php
header('content-type:text/html;charset=utf-8');
if ($_FILES["file"]["error"] > 0)
{
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
}
else
{
    // 文件中文转码
    //iconv('utf-8', 'gbk', $_FILES["file"]["name"]);
    //取出后缀名
    $uniqid = uniqid();
    $ext = strrchr($_FILES["file"]["name"],'.');
    move_uploaded_file($_FILES["file"]["tmp_name"],
        "images/news_cover/" . $uniqid . $ext);
    $arr['code'] = 200;
    $arr['message'] = "已经保存到: " . "images/news_cover/" . $uniqid . $ext;
    $arr['cover'] = "images/news_cover/" . $uniqid . $ext;
    echo json_encode($arr);die;
}
