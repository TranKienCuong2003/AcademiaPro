<?php
session_start(); // Bắt đầu phiên làm việc

// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['username'])) {
    // Xóa tất cả biến phiên
    session_unset();
    // Hủy phiên làm việc
    session_destroy();
    
    // Chuyển hướng về trang đăng nhập với thông báo
    header("Location: /app/views/auth/login.php?message=Đăng xuất thành công.");
    exit();
} else {
    // Nếu chưa đăng nhập, chuyển hướng về trang chính hoặc đăng nhập
    header("Location: /public/index.php");
    exit();
}
?>
