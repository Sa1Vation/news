<?php

header('Content-Type:application/json; charset=utf-8');

echo login($_POST['username'], $_POST['password']);

function login($mail, $pass)
{
    $uName = "";
    $arr = [];
    $flag = false;
    $servername = "localhost";
    $username = "root";
    $password = "root1234";
    $dbname = "news";

    //创建连接对象
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
    $sql = "select user_Name,user_Pass from user where user_Mail='" . $mail . "';";
    if ($pass == $conn->query($sql)->fetch_assoc()['user_Pass']) {
        $uName = $conn->query($sql)->fetch_assoc()['user_Name'];
        $arr = array('status'=>0,'username'=>$uName);
        $flag = true;
    }
    echo ($flag == true ? json_encode($arr):"用户名或密码错误！");

}

?>
