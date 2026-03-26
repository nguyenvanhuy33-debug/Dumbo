<?php
include "config.php";
/*
 * Hàm lấy danh sách sản phẩm
 * Có thể lọc theo category: thuc-an, do-choi, phu-kien, ve-sinh
 */
function getProducts() {
    // Lấy category từ URL nếu có (ví dụ: product.php?action=list&category=thuc-an)
    $category = isset($_GET['category']) ? $_GET['category'] : '';

    if (!empty($category)) {
        // Lọc sản phẩm theo danh mục
        $sql = "SELECT * FROM products WHERE category = '$category' ORDER BY id DESC";
    } else {
        // Lấy toàn bộ sản phẩm
        $sql = "SELECT * FROM products ORDER BY id DESC";
    }

    $result = mysqli_query($GLOBALS['conn'], $sql);
    $products = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
        echo json_encode($products);
    } else {
        echo json_encode(["message" => "Không tìm thấy sản phẩm nào."]);
    }
}

/**
 * Hàm lấy chi tiết một sản phẩm cụ thể
 */
function getProductDetail() {
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    if (empty($id)) {
        echo json_encode(["message" => "Thiếu ID sản phẩm"]);
        return;
    }

    $sql = "SELECT * FROM products WHERE id = '$id'";
    $result = mysqli_query($GLOBALS['conn'], $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        echo json_encode($product);
    } else {
        echo json_encode(["message" => "Sản phẩm không tồn tại."]);
    }
}

/**
 * Hàm thêm sản phẩm mới (Dành cho Admin)
 */
function addProduct() {
    $name        = $_POST['name'];
    $description = $_POST['description'];
    $price       = $_POST['price'];
    $category    = $_POST['category']; // thuc-an, do-choi, phu-kien, ve-sinh
    $image_url   = $_POST['image_url'];

    if (empty($name) || empty($price) || empty($category)) {
        echo "Vui lòng nhập đầy đủ thông tin bắt buộc";
        return;
    }

    $sql = "INSERT INTO products (name, description, price, category, image_url) 
            VALUES ('$name', '$description', '$price', '$category', '$image_url')";

    if (mysqli_query($GLOBALS['conn'], $sql)) {
        echo "Thêm sản phẩm thành công!";
    } else {
        echo "Lỗi: " . mysqli_error($GLOBALS['conn']);
    }
}

// --- Xử lý Request ---
$method = $_SERVER["REQUEST_METHOD"];

if ($method == "GET") {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    
    if ($action == "list") {
        getProducts();
    } elseif ($action == "detail") {
        getProductDetail();
    }
} elseif ($method == "POST") {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    if ($action == "add") {
        addProduct();
    }
}
?>
