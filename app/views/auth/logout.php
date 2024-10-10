<?php
session_start(); // Bắt đầu phiên làm việc

// Định nghĩa đường dẫn cho dễ dàng bảo trì
define('LOGIN_PAGE', '/app/views/auth/login.php');
define('INDEX_PAGE', '/public/index.php');

// Hàm chuyển hướng với mã trạng thái HTTP
function redirect($url, $message = '') {
    if (!empty($message)) {
        // Thêm thông báo vào URL
        $url .= '?message=' . urlencode($message);
    }
    header("Location: $url");
    exit();
}

// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['username'])) {
    // Xóa tất cả biến phiên
    session_unset();
    // Hủy phiên làm việc
    session_destroy();
    
    // Chuyển hướng về trang đăng nhập với thông báo
    redirect(LOGIN_PAGE, 'Đăng xuất thành công.');
} else {
    // Nếu chưa đăng nhập, chuyển hướng về trang chính hoặc đăng nhập
    redirect(INDEX_PAGE);
}
?>
