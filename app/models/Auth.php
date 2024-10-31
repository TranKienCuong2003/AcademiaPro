<?php
require_once __DIR__ . '/../core/Database.php';

class Auth {
    private $conn;

    public function __construct() {
        // Khởi tạo kết nối từ class Database
        $this->conn = Database::getInstance()->getConnection();
    }

    // Phương thức đăng ký người dùng
    public function register($username, $password, $email, $fullname, $phone, $avatar) {
        try {
            // Cập nhật truy vấn SQL để bao gồm fullname, phone và avatar
            $query = "INSERT INTO users (username, password, email, fullname, phone, avatar) VALUES (:username, :password, :email, :fullname, :phone, :avatar)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', password_hash($password, PASSWORD_BCRYPT)); // Mã hóa mật khẩu
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':avatar', $avatar);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // Phương thức đăng nhập người dùng
    public function login($username, $password) {
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                return true;
            }
        }
        return false;
    }
}
?>
