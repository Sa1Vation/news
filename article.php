<?php

function redirect($url)
{
    header("Location: $url");
    exit();
}

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

function getNews($id)
{
    $servername = "localhost";
    $username = "root";
    $password = "root1234";
    $dbname = "news";

    $data = array();
// 创建连接
    $con = mysqli_connect($servername, $username, $password, $dbname);
// 检测连接
    $int_id = (int)$id;
    $sql = "SELECT atl_Id, atl_Title, atl_author, atl_Post_Time, atl_Cover, atl_CV, atl_Cato_id, atl_Content FROM article WHERE atl_Id=".$int_id.";";

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
$atl_id = null;
$type = null;


$_POST['id'] == null ? $atl_id = $_GET['id'] : $atl_id = $_POST['id'];
$_POST['type'] == null ? $type = $_GET['type'] : $type = $_POST['type'];


if($type==0){
    redirect("/article.html?id=".$atl_id);
}else if($type==1){
    echo getNews($atl_id);
}

