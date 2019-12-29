<?php

//announce
header('content-type:application/json;charset=utf8');

define("servername", "localhost");
define("username", "root");
define("password", "root1234");
define("dbname", "news");

class News
{
    public $newsId;
    public $title;
    public $author;
    public $postTime;
    public $cover;
    public $cv;
    public $cat;
    public $content;
}

class Cat
{
    public $id;
    public $name;
}


function publish($title, $author, $content, $cover, $cat)
{

// 创建连接
    $conn = new mysqli(servername, username, password, dbname);
    mysqli_set_charset($conn,"utf8");
// 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }

    $sql = "INSERT INTO article (atl_Title, atl_Author, atl_Content, atl_Post_Time, atl_Cover, atl_Cato_id) VALUES ('" . $title . "', '" . $author . "', '" . $content . "',NOW(),'" . $cover . "','" . $cat . "');";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array('status' => 0));
    } else {
        echo json_encode(array('status' => 0, 'ERROR' => $sql . "<br>" . $conn->error));
    }

    $conn->close();
}


//article
function redirect($url)
{
    header("Location: $url");
    exit();
}

function getNews($id)
{

    $data = array();
// 创建连接
    $con = mysqli_connect(servername, username, password, dbname);
    mysqli_set_charset($con,"utf8");
// 检测连接
    $int_id = (int)$id;
    $sql = "SELECT atl_Id, atl_Title, atl_author, atl_Post_Time, atl_Cover, atl_CV, atl_Cato_id, atl_Content FROM article WHERE atl_Id=" . $int_id . ";";

    $result = mysqli_query($con, $sql);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $news = new News();
            $news->newsId = $row["atl_Id"];
            $news->title = $row["atl_Title"];
            $news->author = $row["atl_author"];
            $news->postTime = $row["atl_Post_Time"];
            $news->cover = $row["atl_Cover"];
            $news->cv = $row["atl_CV"];
            $news->cat = $row["atl_Cato_id"];
            $news->content = $row["atl_Content"];
            $data[] = $news;
        }
        //打印编码后的json字符串
        $json = json_encode($data);
        echo $json;
    } else {
        echo "查询失败";
    }
    mysqli_close($con);

}


//login


function login($mail, $pass)
{
    $arr = [];
    $flag = false;
    //创建连接对象
    $conn = new mysqli(servername, username, password, dbname);
    // Check connection
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
    $sql = "select user_Name,user_Pass from user where user_Mail='" . $mail . "';";
    if ($pass == $conn->query($sql)->fetch_assoc()['user_Pass']) {
        $uName = $conn->query($sql)->fetch_assoc()['user_Name'];
        $arr = array('status' => 0, 'username' => $uName);
        $flag = true;
    }
    echo($flag == true ? json_encode($arr) : "用户名或密码错误！");

}

//pullNews


function pullNews($type, $startRow, $rows)
{

    $data = array();
// 创建连接
    $con = mysqli_connect(servername, username, password, dbname);
    mysqli_set_charset($con,"utf8");
// 检测连接
    if ($type == 0) {
        $sql = "SELECT atl_Id, atl_Title, atl_author, atl_Post_Time, atl_Cover, atl_CV, atl_Cato_id FROM article limit " . $startRow . "," . $rows . ";";
        $sql2 = "SELECT count(*) as AllNum FROM article;";
    } else {
        $sql = "SELECT atl_Id, atl_Title, atl_author, atl_Post_Time, atl_Cover, atl_CV, atl_Cato_id FROM article WHERE atl_Cato_Id=" . $type . "limit " . $startRow . "," . $rows . ";";
        $sql2 = "SELECT count(*) as AllNum FROM article WHERE atl_Id=" . $type . ";";
    }

    $result = mysqli_query($con, $sql);
    $totalRows = mysqli_query($con, $sql2);

    if ($result && $totalRows) {
        while ($row = mysqli_fetch_array($result)) {
            $news = new News();
            $news->newsId = $row["atl_Id"];
            $news->title = $row["atl_Title"];
            $news->author = $row["atl_author"];
            $news->postTime = $row["atl_Post_Time"];
            $news->cover = $row["atl_Cover"];
            $news->cv = $row["atl_CV"];
            $news->cat = $row["atl_Cato_id"];
            $data[] = $news;
        }
        //打印编码后的json字符串
        $json = json_encode($data);
        setcookie("totalRows", mysqli_fetch_assoc($totalRows)['AllNum'], time() + 3600, "newsManage.html");
        return $json;
    } else {
        echo "查询失败";
    }
    mysqli_close($con);
}

//pullcat

function pullCat()
{

    $data = array();
// 创建连接
    $con = mysqli_connect(servername, username, password, dbname);
    mysqli_set_charset($con,"utf8");
// 检测连接
    $sql = "SELECT * FROM category;";

    $result = mysqli_query($con, $sql);

    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $cat = new Cat();
            $cat->id = $row["cato_Id"];
            $cat->name = $row["cato_Name"];
            $data[] = $cat;
        }
        //打印编码后的json字符串
        $json = json_encode($data);
        return $json;
    } else {
        echo "查询失败";
    }
    mysqli_close($con);
}

//register


function insert($name, $pass, $mail, $tel)
{
    $flag = false;


    try {
        $conn = new PDO("mysql:host=" . servername . ";dbname=" . dbname, username, password);
        // 设置 PDO 错误模式，用于抛出异常
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        date_default_timezone_set("Asia/Shanghai");
        $regtime = date('Y-m-d H:i:s');
        $sql = "INSERT INTO user (user_Name, user_Pass, user_Mail, user_Tel, user_Reg_Time)
VALUES ('$name', '$pass', '$mail', '$tel', '$regtime')";
        // 使用 exec() ，没有结果返回
        $conn->exec($sql);
        $flag = true;
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
    return $flag;
}


//业务逻辑实现，根据action来调用不同的函数


if ($_GET['action'] == "announce") {
    if ($_POST['title'] != null && $_POST['author'] != null && $_POST['content'] != null && $_POST['cover'] != null) {
        echo publish($_POST['title'], $_POST['author'], $_POST['content'], $_POST['cover'], $_POST['cat']);
    } else {
        echo json_encode(array('status' => 2));       //status 2 表示没有从前端接收到数据
    }


} elseif ($_GET['action'] == "article") {
    $atl_id = null;
    $type = null;


    $_POST['id'] == null ? $atl_id = $_GET['id'] : $atl_id = $_POST['id'];
    $_POST['type'] == null ? $type = $_GET['type'] : $type = $_POST['type'];


    if ($type == 0) {
        redirect("/article.html?id=" . $atl_id);
    } else if ($type == 1) {
        echo getNews($atl_id);
    }


} elseif ($_GET['action'] == "login") {
    echo login($_POST['username'], $_POST['password']);


} elseif ($_GET['action'] == "register") {
    if (insert($_POST['username'], $_POST['password'], $_POST['mail'], $_POST['tel'])) {
        echo "registerSuccess";
    } else {
        echo "未知异常!";
    }


} elseif ($_GET['action'] == "pullNews") {
    echo pullNews($_POST['cato'], $_POST['startRow'], $_POST['rows']);


} elseif ($_GET['action'] == "uploadImg") {
    if ($_FILES["file"]["error"] > 0) {
        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    } else {
        // 文件中文转码
        //iconv('utf-8', 'gbk', $_FILES["file"]["name"]);
        //取出后缀名
        $uniqid = uniqid();
        $ext = strrchr($_FILES["file"]["name"], '.');
        move_uploaded_file($_FILES["file"]["tmp_name"],
            "images/news_cover/" . $uniqid . $ext);
        $arr['code'] = 200;
        $arr['message'] = "已经保存到: " . "images/news_cover/" . $uniqid . $ext;
        $arr['cover'] = "images/news_cover/" . $uniqid . $ext;
        echo json_encode($arr);
        die;
    }


} elseif ($_GET['action'] == "pullCat") {
    echo pullCat();

}