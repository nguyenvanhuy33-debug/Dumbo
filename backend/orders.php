<?php
include "config.php";

// Hàm tạo đơn hàng mới
function createOrder() {
    $user_id      = $_POST['user_id']; // ID của người dùng đang đăng nhập
    $product_name = $_POST['product_name'];
    $quantity     = $_POST['quantity'];
    $total_price  = $_POST['total_price'];

    // Kiểm tra dữ liệu đầu vào
    if (empty($user_id) || empty($product_name) || empty($quantity)) {
        echo "Thông tin đơn hàng không đầy đủ";
        return;
    }

    // Câu lệnh SQL thêm đơn hàng
    $sql = "INSERT INTO orders (user_id, product_name, quantity, total_price) 
            VALUES ('$user_id', '$product_name', '$quantity', '$total_price')";

    if (mysqli_query($GLOBALS['conn'], $sql)) {
        echo "Đặt hàng thành công!";
    } else {
        echo "Lỗi: " . mysqli_error($GLOBALS['conn']);
    }
}

// Hàm lấy danh sách đơn hàng của một người dùng
function getOrderHistory() {
    $user_id = $_GET['user_id'];

    $sql = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY order_date DESC";
    $result = mysqli_query($GLOBALS['conn'], $sql);

    $orders = [];
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $orders[] = $row;
        }
        echo json_encode($orders); // Trả về dạng JSON để frontend dễ xử lý
    } else {
        echo "Bạn chưa có đơn hàng nào.";
    }
}

// Xử lý Request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    if ($action == "create") {
        createOrder();
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    $action = $_GET['action'];
    if ($action == "history") {
        getOrderHistory();
    }
}
?>
