function init() {
    getTime();
    setInterval(getTime, 1000);
    loadData();
}

function getTime() {     	//获取时间
    var date = new Date();

    var year = date.getFullYear();
    var month = date.getMonth();
    var day = date.getDate();

    var hour = date.getHours();
    var minute = date.getMinutes();
    var second = date.getSeconds();

    //这样写显示时间在1~9会挤占空间；所以要在1~9的数字前补零;
    if (hour < 10) {
        hour = '0' + hour;
    }
    if (minute < 10) {
        minute = '0' + minute;
    }
    if (second < 10) {
        second = '0' + second;
    }


    var x = date.getDay();//获取星期


    var time = month + '/' + day + '  ' + hour + ':' + minute + ':' + second
    document.getElementById("currentTime").innerHTML = time;//将时间显示在div内
}

function loadData() {
    var username = localStorage.getItem("username");
    if (username == null || username == "#username") {
        document.getElementById("loginItem").style.display = "block";
        document.getElementById("logoutItem").style.display = "none";
    } else {
        document.getElementById("loginItem").style.display = "none";
        document.getElementById("logoutItem").style.display = "block";
        document.getElementById("user").innerText = username;
    }
}

function logout() {
    localStorage.clear();
    window.location.href = "index.html";
}

function getCookie(name) {
    var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");

    if (arr = document.cookie.match(reg))

        return unescape(arr[2]);
    else
        return null;
}

function pullCat() {
    $.ajax({
        type: "POST",
        url: "news.php?action=pullCat",
        data: {},
        dataType: "json",
        success: function (result) {
            var i = 0;
            for (let cat in result) {
                var item = '<li class=\"nav-item\"><a class=\"animated fadeIn\" href=\"#tab-A\" data-toggle=\"tab\"><span class=\"tab-head\"><span class=\"tab-text-title\">' + result[cat].name + '</span></span></a></li>';
                $("#catItems").append(item);
                var tabitem = '<div class="tab-pane fade"><div class="row"></div></div>';
                $("#tabs").append(tabitem);
                for (j = 0; j <= 3; j++) {
                    var artitem = '<div class="col-md-3"><div class="post-block-style clearfix"><div class="post-thumb"><a href="#"><img class="img-fluid" src="images/news/lifestyle/image1.jpg" alt=""></a></div><div class="post-content"><h2 class="post-title title-small"><a href="#">That wearable on your wrist soon your…</a></h2></div></div></div>';
                    $("#tabs > div > div").eq(i).append(artitem);
                }
                i = i + 1;
            }
            $('#catItems > li > a').hover(function () {
                $('#catItems > li > a').attr("class", "animated fadeIn");
                $(this).attr("class", "animated fadeIn active");
                var index = $('#catItems > li > a').index(this);
                $("#tabs > div").attr("class", "tab-pane fade")
                $("#tabs > div").eq(index).attr("class", "tab-pane animated fadeIn active")
            })
        }
    })
}

function pullNews(type,startRow,rows) {
    $.ajax({
        type: "POST",
        url: "news.php?action=pullNews",
        dataType: "json",
        data: {
            "cato": type,
            "startRow": startRow,
            "rows": rows
        },
        success: function (result) {
            return result;
        }
    })
}
