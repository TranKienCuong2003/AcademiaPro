<?php
// Tải Composer autoload
require_once __DIR__ . '/vendor/autoload.php';

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        // Khởi tạo Dotenv và load file .env
        $this->loadEnvironmentVariables();
    }

    private function loadEnvironmentVariables() {
        try {
            $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
            $dotenv->load();

            $this->host = $_ENV['DB_HOST'];
            $this->db_name = $_ENV['DB_NAME'];
            $this->username = $_ENV['DB_USERNAME'];
            $this->password = $_ENV['DB_PASSWORD'];
        } catch (Exception $e) {
            error_log("Environment variable loading error: " . $e->getMessage());
            die("Có lỗi xảy ra khi tải biến môi trường. Vui lòng kiểm tra tệp nhật ký để biết thêm chi tiết.");
        }
    }

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("SET NAMES 'utf8'");
        } catch (PDOException $exception) {
            error_log("Connection error: " . $exception->getMessage());
            die("Kết nối thất bại. Vui lòng kiểm tra tệp nhật ký để biết thêm chi tiết.");
        }
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn = null;
    }
}
?>
