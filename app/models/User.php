<?php
require_once __DIR__ . '/../Database.php';

class User {
    private $conn;

    public function __construct() {
        // Khởi tạo kết nối từ class Database
        $this->conn = Database::getInstance()->getConnection();
    }

    public function register($username, $password, $email) {
        $query = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', password_hash($password, PASSWORD_BCRYPT)); // Mã hóa mật khẩu
        $stmt->bindParam(':email', $email);
        
        return $stmt->execute();
    }

    public function login($username, $password) {
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            // Kiểm tra mật khẩu
            if (password_verify($password, $user['password'])) {
                return true;
            }
        }
        return false;
    }
}
?>
