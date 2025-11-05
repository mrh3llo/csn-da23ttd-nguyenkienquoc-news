function getDateTime() {
    const today = new Date();

    const day = today.getDate();
    const month = today.getMonth() + 1;
    const year = today.getFullYear();

    const hours = today.getHours();
    const minutes = today.getMinutes();

    let displayDate =
    `Việt Nam, ngày ${day} tháng ${month} năm ${year} <br> ${hours} : ${minutes}`;

    document.getElementById('display_date_time').innerHTML = displayDate;
}

// Gọi hàm getDateTime mỗi 1000 mili giây, tức là 1 giây
setInterval(getDateTime, 60000);
getDateTime()