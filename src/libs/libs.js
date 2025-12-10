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

// Xử lý đăng ký
{
function handleSignUpForm(formId, actionUrl) {
    const form = document.getElementById(formId);
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        validateSignUpForm(event, actionUrl);
    });
}

function validateSignUpForm(event, actionUrl) {
    event.preventDefault();

    let email = document.getElementById("user_email").value;
    let name = document.getElementById("user_name").value;
    let password = document.getElementById("user_password").value;
    let confirm = document.getElementById("user_password_comfirm").value;

    let errors = [];

    // Kiểm tra dữ liệu không được để trống
    if (!email)
        errors.push("Không để trống email");
    if (!name)
        errors.push("Không được để trống tên người dùng");
    if (!password)
        errors.push("Không được để trống mật khẩu");
    if (!confirm)
        errors.push("Xin hãy xác nhận mật khẩu");

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))
        errors.push("Email không hợp lệ!");

    if(/\s/.test(name))
        errors.push("Tên người dùng không được chứa khoảng trắng!");

    if (password.length < 8)
        errors.push("Mật khẩu phải có ít nhất 8 ký tự!");
    if (/\s/.test(password))
    errors.push("Mật khẩu không được chứa khoảng trắng!");

    if (confirm != password)
        errors.push("Mật khẩu không trùng khớp!");

    // Thông báo trạng thái
    if (errors.length <= 0) {
        // Nếu hợp lệ, gửi dữ liệu tới PHP
        const formData = new FormData();
        formData.append('user_email', email);
        formData.append('user_name', name);
        formData.append('user_password', password);
        formData.append('user_password_comfirm', confirm);

        fetch(actionUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            // Kiểm tra HTTP status
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(text);
                });
            }
            return response.text();
        })
        .then(data => {
            document.getElementById("log_status").innerHTML = data;
            console.log("Đăng ký thành công:", data);
            // Xóa form sau 2 giây
            setTimeout(() => {
                document.getElementById("signUpForm").reset();
                document.getElementById("log_status").innerHTML = "";
            }, 2000);
        })
        .catch(error => {
            document.getElementById("log_status").innerHTML = "Lỗi: " + error.message;
            console.error("Lỗi:", error);
        });
    } else {
        document.getElementById("log_status").innerHTML = errors.join("<br>");
    }
}
}

// Xử lý đăng nhập
{
// Bổ sung dữ liệu từ CSDL về để kiểm tra thông tin đăng nhập
function handleSignInForm(formId, actionUrl) {
    const form = document.getElementById(formId);
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        validateSignInForm(event, actionUrl);
    });
}

function validateSignInForm(event, actionUrl) {
    event.preventDefault();

    let name = document.getElementById('user_name').value;
    let password = document.getElementById('user_password').value;

    let errors = [];

    // Kiểm tra dữ liệu không được để trống
    if(!name)
        errors.push('Không để trống tên người dùng');
    if(!password)
        errors.push('Không được để trống mật khẩu');

    if(/\s/.test(name))
        errors.push("Tên người dùng không được chứa khoảng trắng!");
    
    if(password.length < 8)
        errors.push('Mật khẩu phải có ít nhất 8 ký tự!');
    if(/\s/.test(password))
        errors.push('Mật khẩu không dược chứa khoảng trắng!');

    // Thông báo trạng thái
    if(errors.length <= 0) {
        // Gửi POST với FormData (POST cho phép body)
        const formData = new FormData();
        formData.append('user_name', name.trim());
        formData.append('user_password', password);

        fetch(actionUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text || response.statusText); });
            }
            return response.text();
        })
        .then(data => {
            document.getElementById("log_status").innerHTML = data;
            console.log("Đăng nhập thành công:", data);

            // Nếu muốn chuyển hướng sau khi đăng nhập thành công, xử lý ở đây.
            setTimeout(() => {
                document.getElementById("signInForm").reset();
                document.getElementById("log_status").innerHTML = "";
            }, 1200);
        })
        .catch(error => {
            document.getElementById("log_status").innerHTML = "Lỗi: " + error.message;
            console.error("Lỗi đăng nhập:", error);
        });
    } else {
        document.getElementById('log_status').innerHTML = errors.join('<br>');
    }
}

function clearErrors() {
    document.getElementById("log_status").innerHTML = "";
}
}

// Đọc dữ liệu từ URL
{
function reciveValue(value) {
    const urlValue = new URLSearchParams(window.location.search);
    return urlValue.get(value);
}
}

// Hiển thị bài báo
{
// Tải danh sách bài báo từ server và chèn vào container
function displayListNews(containerId, fetchUrl) {
    const container = document.getElementById(containerId);
    if(!container) return;

    fetch(fetchUrl, {
        method: 'GET',
        credentials: 'same-origin'
    })
    .then(resp => {
        if(!resp.ok)
            return resp.text()
            .then(t => {
                throw new Error(t || resp.statusText);
            });
        return resp.text();
    })
    .then(html => {
        container.innerHTML = html;
    })
    .catch(err => {
        container.innerHTML = '<p>Không thể tải tin tức: ' + (err.message || 'Lỗi') + '</p>';
        console.error('Lỗi tải displayListNews:', err);
    });
}

// Hiển thị bài báo
function displayNews(containerId, fetchUrl) {
    const container = document.getElementById(containerId);

    if(!container) return;

    fetch(fetchUrl, {
        method: 'GET',
        credentials: 'same-origin'
    })
    .then(resp => {
        if(!resp.ok)
            return resp.text()
            .then(t => {
                throw new Error(t || resp.statusText);
            });
        return resp.text();
    })
    .then(html => {
        container.innerHTML = html;
    })
    .catch(err => {
        container.innerHTML = '<p>Không thể tải tin tức: ' + (err.message || 'Lỗi') + '</p>';
        console.error('Lỗi tải displayNews', err);
    })
}
}

// Tự động khởi tạo hiển thị tin tức khi có phần tử #displayNews
document.addEventListener('DOMContentLoaded', function () {
    try {
        var container = document.getElementById('displayNews');
        if(!container) return;

        // Nếu có newsId trong URL -> hiển thị chi tiết
        var newsId = reciveValue('newsId');
        if(newsId) {
            if(typeof displayNews === 'function') {
                displayNews('displayNews', '../php/displayNews.php?newsId=' + encodeURIComponent(newsId));
            }
            return;
        }

        // Nếu không có newsId -> hiển thị danh sách
        if(typeof displayListNews === 'function') {
            displayListNews('displayNews', '../php/displayListNews.php');
        }
    } catch(e) {
        console.error('Auto-init displayNews failed:', e);
    }
});

// --- Search bar: realtime search with debounce ---
 (function(){
     // simple debounce
     function debounce(fn, wait) {
         let t = null;
         return function() {
             const args = arguments;
             clearTimeout(t);
             t = setTimeout(() => fn.apply(this, args), wait);
         }
     }

     function renderSearchResults(html) {
         const container = document.getElementById('search_results');
         if(!container) return;
         if (!html || html.trim() === '') {
             container.style.display = 'none';
             container.innerHTML = '';
             return;
         }
         container.style.display = 'block';
         container.innerHTML = html;
     }

     async function doSearch(q) {
         if (!q || q.trim() === '') {
             renderSearchResults('');
             return;
         }
         try {
             const resp = await fetch('../php/searchNews.php?q=' + encodeURIComponent(q), { method: 'GET', credentials: 'same-origin' });
             if (!resp.ok) {
                 const t = await resp.text();
                 throw new Error(t || resp.statusText);
             }
             const html = await resp.text();
             renderSearchResults(html);
         } catch (err) {
             console.error('Search error:', err);
         }
     }

     // Attach to input if present
     document.addEventListener('DOMContentLoaded', function() {
         try {
             const input = document.getElementById('search_input');
             if (!input) return;
             const debounced = debounce(function(e){
                 const q = e.target.value;
                 doSearch(q);
             }, 300);
             input.addEventListener('input', debounced);

             // hide results on Escape
             input.addEventListener('keydown', function(e){
                 if (e.key === 'Escape') {
                     const container = document.getElementById('search_results');
                     if (container) container.style.display = 'none';
                 }
             });
         } catch(e) { console.error('Init search failed:', e); }
     });
 })();