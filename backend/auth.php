<?php
include "config.php";

// Hàm đăng ký
function register() {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra dữ liệu
    if ($username == "" || $password == "") {
        echo "Vui lòng nhập đầy đủ";
        return;
    }

    // Kiểm tra tài khoản đã tồn tại chưa
    $check = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($GLOBALS['conn'], $check);

    if (mysqli_num_rows($result) > 0) {
        echo "Tài khoản đã tồn tại";
        return;
    }

    // Thêm user mới
    $sql = "INSERT INTO users (username, password) 
            VALUES ('$username', '$password')";

    if (mysqli_query($GLOBALS['conn'], $sql)) {
        echo "Đăng ký thành công";
    } else {
        echo "Lỗi đăng ký";
    }
}

// Hàm đăng nhập
function login() {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == "" || $password == "") {
        echo "Vui lòng nhập đầy đủ";
        return;
    }

    $sql = "SELECT * FROM users 
            WHERE username='$username' AND password='$password'";
    
    $result = mysqli_query($GLOBALS['conn'], $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "Đăng nhập thành công";
    } else {
        echo "Sai tài khoản hoặc mật khẩu";
    }
}

// Xử lý request
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'];

    if ($action == "register") {
        register();
    } else if ($action == "login") {
        login();
    }
}
?>