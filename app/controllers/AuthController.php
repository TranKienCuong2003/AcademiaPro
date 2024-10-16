<?php
session_start();

require_once __DIR__ . '/../models/Auth.php';

class AuthController {
    // Hàm đăng nhập
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            // Khởi tạo đối tượng User
            $user = new User();
            $result = $user->login($username, $password);

            if ($result) {
                $_SESSION['username'] = $username;

                // Chuyển hướng đến trang chính
                $this->redirect('/public/index.php');
            } else {
                $_SESSION['error'] = "Đăng nhập thất bại, vui lòng kiểm tra lại tên đăng nhập hoặc mật khẩu.";

                // Chuyển hướng lại trang đăng nhập
                $this->redirect('/app/views/auth/login.php');
            }
            exit();
        }
    }

    // Hàm đăng ký
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            // Khởi tạo đối tượng User
            $user = new User();
            $result = $user->register($username, $password, $email);

            if ($result) {
                // Chuyển hướng đến trang đăng nhập nếu đăng ký thành công
                $this->redirect('/app/views/auth/login.php');
            } else {
                // Chuyển hướng lại trang đăng ký nếu thất bại
                $this->redirect('/app/views/auth/register.php');
            }
            exit();
        }
    }

    // Hàm đăng xuất
    public function logout() {
        if (isset($_SESSION['username'])) {
            session_unset();
            session_destroy();

            // Chuyển hướng về trang đăng nhập với thông báo
            $this->redirect('/app/views/auth/login.php', 'Đăng xuất thành công.');
        } else {
            // Chuyển hướng về trang chính nếu chưa đăng nhập
            $this->redirect('/public/index.php');
        }
    }

    // Hàm chuyển hướng
    private function redirect($url, $message = '') {
        if (!empty($message)) {
            $url .= '?message=' . urlencode($message);
        }
        header("Location: $url");
        exit();
    }
}

// Xử lý yêu cầu từ URL
if (isset($_GET['action'])) {
    $authController = new AuthController();

    switch ($_GET['action']) {
        case 'login':
            $authController->login();
            break;
        case 'register':
            $authController->register();
            break;
        case 'logout':
            $authController->logout();
            break;
        default:
            header('Location: /public/index.php');
            exit();
    }
}
?>
