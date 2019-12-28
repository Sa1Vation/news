<?php
header('content-type:application/json;charset=utf8');

if($_POST['title']!=null && $_POST['author']!=null && $_POST['content']!=null && $_POST['cover']!=null){
    echo publish($_POST['title'], $_POST['author'], $_POST['content'], $_POST['cover'], $_POST['cat']);
}else{
    echo json_encode(array('status'=>2));       //status 2 表示没有从前端接收到数据
}


function publish($title, $author, $content, $cover, $cat) {
    $servername = "localhost";
    $username = "root";
    $password = "root1234";
    $dbname = "news";

// 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }

    $sql = "INSERT INTO article (atl_Title, atl_Author, atl_Content, atl_Post_Time, atl_Cover, atl_Cato_id) VALUES ('".$title."', '".$author."', '".$content."',NOW(),'".$cover."','".$cat."');";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array('status'=>0));
    } else {
        echo json_encode(array('status'=>0,'ERROR'=>$sql . "<br>" . $conn->error));
    }

    $conn->close();
}