<?php
include "config.php";

// Hàm xử lý đăng nhập
function login() {

    // Lấy dữ liệu từ request
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra dữ liệu rỗng
    if ($username == "" || $password == "") {
        echo "Vui lòng nhập đầy đủ";
        return;
    }

    // Truy vấn kiểm tra tài khoản
    $sql = "SELECT * FROM users 
            WHERE username='$username' AND password='$password'";
    
    $result = mysqli_query($GLOBALS['conn'], $sql);

    // Kiểm tra kết quả
    if (mysqli_num_rows($result) > 0) {
        echo "Đăng nhập thành công";
    } else {
        echo "Sai tài khoản hoặc mật khẩu";
    }
}

// Gọi hàm khi có POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    login();
}
?>