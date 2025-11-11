// Hàm cập nhật thời gian theo thời gian thực
{
    function getDateTime() {
    const today = new Date();

    const day = today.getDate();
    const month = today.getMonth() + 1;
    const year = today.getFullYear();

    const hours = today.getHours();
    const minutes = today.getMinutes();
    
    let displayDate =
    `Việt Nam, ngày ${day} tháng ${month} năm ${year} <br> ${hours} : ${minutes}`;

    // Nếu số phút và giờ nhỏ hơn 10 thì thêm số 0 vào trước. Ví dụ từ 8 : 5 thành 08 : 05
    if(hours < 10 && minutes < 10)
        displayDate =
        `Việt Nam, ngày ${day} tháng ${month} năm ${year} <br> 0${hours} : 0${minutes}`;
    else if(hours < 10)
        displayDate =
        `Việt Nam, ngày ${day} tháng ${month} năm ${year} <br> 0${hours} : ${minutes}`;
    else if(minutes < 10)
        displayDate =
        `Việt Nam, ngày ${day} tháng ${month} năm ${year} <br> 0${hours} : 0${minutes}`;

        document.getElementById('display_date_time').innerHTML = displayDate;
    }

    // Gọi hàm getDateTime mỗi 1000 mili giây, tức là 1 giây
    setInterval(getDateTime, 60000);
    getDateTime()
}

// Đường link
{
    function jumpTo(path) {
        window.location.href = path;
    }
}