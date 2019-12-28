<?php

if(insert($_POST['username'],$_POST['password'],$_POST['mail'],$_POST['tel'])){
    echo "registerSuccess";
}else{
    echo "未知异常!";
}

function insert($name, $pass, $mail, $tel)
{
    $flag = false;
    $servername = "localhost";
    $username = "root";
    $password = "root1234";
    $dbname = "news";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // 设置 PDO 错误模式，用于抛出异常
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        date_default_timezone_set("Asia/Shanghai");
        $regtime = date('Y-m-d H:i:s');
        $sql = "INSERT INTO user (user_Name, user_Pass, user_Mail, user_Tel, user_Reg_Time)
VALUES ('$name', '$pass', '$mail', '$tel', '$regtime')";
        // 使用 exec() ，没有结果返回
        $conn->exec($sql);
        $flag = true;
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
    return $flag;
}
?>
