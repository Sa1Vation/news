<?php
//设置编码格式
header("Content-type:application/json;charset=utf-8");
echo pullNews($_POST['cato'], $_POST['startRow'], $_POST['rows']);

class News
{
    public $newsId;
    public $title;
    public $author;
    public $postTime;
    public $cover;
    public $cv;
    public $cat;
}

function pullNews($type, $startRow, $rows)
{
    $servername = "localhost";
    $username = "root";
    $password = "root1234";
    $dbname = "news";

    $data = array();
// 创建连接
    $con = mysqli_connect($servername, $username, $password, $dbname);
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
        setcookie("totalRows",mysqli_fetch_assoc($totalRows)['AllNum'],time()+3600,"newsManage.html");
        return $json;
    } else {
        echo "查询失败";
    }
    mysqli_close($con);
}

?>