<?php
require_once __DIR__ . '/../models/User.php';

class RegisterController {
    public function __construct() {
        $this->register();
    }

    public function register() {
        // Kiểm tra nếu có dữ liệu được gửi từ form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            // Khởi tạo đối tượng User
            $user = new User();
            // Gọi phương thức đăng ký
            $result = $user->register($username, $password, $email);

            if ($result) {
                // Đăng ký thành công, chuyển hướng đến trang đăng nhập
                header("Location: /app/views/auth/login.php");
                exit();
            } else {
                // Xử lý nếu đăng ký thất bại
                echo "Đăng ký thất bại, vui lòng thử lại.";
            }
        }
    }
}

// Khởi tạo và gọi RegisterController
new RegisterController();
?>
