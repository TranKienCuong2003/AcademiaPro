<?php
require_once __DIR__ . '/../models/User.php';

class LoginController {
    public function __construct() {
        $this->login(); // Gọi phương thức login trong constructor
    }

    public function login() {
        // Kiểm tra nếu có dữ liệu được gửi từ form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            // Khởi tạo đối tượng User
            $user = new User();
            // Gọi phương thức đăng nhập
            $result = $user->login($username, $password);

            if ($result) {
                // Đăng nhập thành công, lưu thông tin người dùng vào session
                session_start();
                $_SESSION['username'] = $username;
                // Chuyển hướng đến trang chính hoặc trang bạn muốn
                header("Location: /public/index.php");
                exit(); // Dừng thực thi tiếp theo
            } else {
                // Xử lý nếu đăng nhập thất bại
                session_start();
                $_SESSION['error'] = "Đăng nhập thất bại, vui lòng kiểm tra lại tên đăng nhập hoặc mật khẩu.";
                header("Location: /app/views/auth/login.php");
                exit();
            }
        }
    }
}

// Khởi tạo đối tượng LoginController để gọi constructor
new LoginController();
?>
