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
    if(hours < 10)
        displayDate =
        `Việt Nam, ngày ${day} tháng ${month} năm ${year} <br> 0${hours} : ${minutes}`;
    if(minutes < 10)
        displayDate =
        `Việt Nam, ngày ${day} tháng ${month} năm ${year} <br> 0${hours} : 0${minutes}`;

        document.getElementById('display_date_time').innerHTML = displayDate;
    }

    // Gọi hàm getDateTime mỗi 1000 mili giây, tức là 1 giây
    setInterval(getDateTime, 60000);
    getDateTime()
}

// Đường link
// Chỉ có hàm jumpTo('đường dẫn);
{
    function jumpTo(path) {
        window.location.href = path;
    }
}

// Xử lý đăng nhâp, đăng ký
{
    function validateSignUpForm(event) {
        event.preventDefault();

        let email = document.getElementById('user_email').value;
        let name = document.getElementById('user_name').value;
        let password = document.getElementById('user_password').value;
        let confirm = document.getElementById('user_password_comfirm').value;

        let errors = [];

        // Kiểm tra dữ liệu không được để trống
        if(!email) errors.push('Không để trống email');
        if(!name) errors.push('Không được để trống tên người dùng');
        if(!password) errors.push('Không được để trống mật khẩu');
        if(!confirm) errors.push('Xin hãy xác nhận mật khẩu');

        if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))
            errors.push('Email không hợp lệ!');
        
        if(password.length < 8)
            errors.push('Mật khẩu phải có ít nhất 8 ký tự!');
        if(/\s/.test(password))
            errors.push('Mật khẩu không dược chứa khoảng trắng!');

        if(confirm != password)
            errors.push('Mật khẩu không trùng khớp!');

        // Thông báo trạng thái
        if(errors.length <= 0) {
            setTimeout(() => {
                document.getElementById('log_status').innerHTML = 'ĐĂNG NHẬP THÀNH CÔNG!!!';
                console.log('Đăng nhập thành công');
            }, 1000);
        }
        else {
            document.getElementById('log_status').innerHTML = errors.join('<br>');
        }
    }

    // Bổ sung dữ liệu từ CSDL về để kiểm tra thông tin đăng nhập
    function validateSignInForm(event) {
        event.preventDefault();

        let email = document.getElementById('user_email').value;
        let password = document.getElementById('user_password').value;

        let errors = [];

        // Kiểm tra dữ liệu không được để trống
        if(!email) errors.push('Không để trống email');
        if(!password) errors.push('Không được để trống mật khẩu');

        if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))
            errors.push('Email không hợp lệ!');
        
        if(password.length < 8)
            errors.push('Mật khẩu phải có ít nhất 8 ký tự!');
        if(/\s/.test(password))
            errors.push('Mật khẩu không dược chứa khoảng trắng!');

        // Thông báo trạng thái
        if(errors.length <= 0) {
            setTimeout(() => {
                document.getElementById('log_status').innerHTML = 'ĐĂNG NHẬP THÀNH CÔNG!!!';
                console.log('Đăng nhập thành công');
            }, 1000);
        }
        else {
            document.getElementById('log_status').innerHTML = errors.join('<br>');
        }
    }
}

// Đọc dữ liệu từ URL
{
    function reciveValue(value) {
        const urlValue = new URLSearchParams(window.location.search);
        return urlValue.get(value);
    }
}