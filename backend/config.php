<?php
// Thông tin kết nối database
$host = "localhost";
$user = "root";
$password = "123456";
$database = "dumbo";

// Tạo kết nối
$conn = mysqli_connect($host, $user, $password, $database);

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
?>