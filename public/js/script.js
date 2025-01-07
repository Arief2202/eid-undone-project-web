$(document).ready(function() {
    const mon = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Okt",
        "Nov",
        "Dec"
    ];
    function updateTime(){
        const date = new Date();
        var strDate = date.getDate().toString();
        strDate += " " + mon[date.getMonth()];
        strDate += " " + date.getFullYear().toString();
        strDate += " " + date.getHours().toString();
        strDate += ":" + (date.getMinutes() < 10 ? "0" : "");
        strDate += date.getMinutes().toString();
        strDate += ":" + (date.getSeconds() < 10 ? "0" : "");
        strDate += date.getSeconds().toString();
        document.getElementById("Time").innerHTML = strDate;
    };
    updateTime();

    setInterval(function () {
        updateTime();
    }, 1000);
});
