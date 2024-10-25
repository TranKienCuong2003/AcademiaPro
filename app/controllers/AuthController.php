<?php
session_start();

require_once __DIR__ . '/../models/Auth.php';

class AuthController {
    // Hàm đăng nhập
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $auth = new Auth(); // Sử dụng lớp Auth thay vì User
            $result = $auth->login($username, $password);

            if ($result) {
                $_SESSION['username'] = $username;
                $this->redirect('/public/index.php');
            } else {
                $_SESSION['error'] = "Đăng nhập thất bại. Vui lòng kiểm tra lại thông tin.";
                $this->redirect('/app/views/auth/login.php');
            }
            exit();
        }
    }

    // Hàm đăng ký
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $email = trim($_POST['email']);
            $fullname = trim($_POST['fullname']) ?? null;
            $phone = trim($_POST['phone']) ?? null;
            $avatar = trim($_POST['avatar']) ?? null;

            $auth = new Auth(); // Sử dụng lớp Auth
            // Gọi phương thức register với tất cả các tham số
            $result = $auth->register($username, $password, $email, $fullname, $phone, $avatar);

            if ($result) {
                // Chuyển hướng với thông báo thành công
                $this->redirect('/app/views/auth/login.php', 'Bạn đã đăng ký thành công và được chuyển sang trang Đăng nhập.');
            } else {
                $_SESSION['error'] = "Đăng ký thất bại. Vui lòng thử lại.";
                $this->redirect('/app/views/auth/register.php');
            }
            exit();
        }
    }

    // Hàm đăng xuất
    public function logout() {
        session_unset();
        session_destroy();
        $this->redirect('/app/views/auth/login.php', 'Đăng xuất thành công.');
    }

    // Hàm chuyển hướng với thông báo
    private function redirect($url, $message = '') {
        if (!empty($message)) {
            $_SESSION['message'] = $message;
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
