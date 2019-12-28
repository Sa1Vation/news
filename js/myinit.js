function init() {
    getTime();
    setInterval(getTime,1000);
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
    if(username == null || username == "#username"){
        document.getElementById("loginItem").style.display = "block";
        document.getElementById("logoutItem").style.display = "none";
    }else {
        document.getElementById("loginItem").style.display = "none";
        document.getElementById("logoutItem").style.display = "block";
        document.getElementById("user").innerText = username;
    }
}
function logout() {
    localStorage.clear();
    window.location.href = "index.html";
}

function getCookie(name)
{
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");

    if(arr=document.cookie.match(reg))

        return unescape(arr[2]);
    else
        return null;
}
