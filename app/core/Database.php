<?php
require_once __DIR__ . '/../../vendor/autoload.php';

class Database {
    private static $instance = null;
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    private function __construct() {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $this->host = $_ENV['DB_HOST'];
        $this->db_name = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->exec("SET NAMES 'utf8'");
            } catch (PDOException $exception) {
                error_log("Connection error: " . $exception->getMessage());
                if ($_ENV['APP_ENV'] !== 'production') {
                    echo "Đã xảy ra lỗi khi kết nối đến cơ sở dữ liệu: " . $exception->getMessage();
                } else {
                    echo "Đã xảy ra lỗi khi kết nối đến cơ sở dữ liệu.";
                }
            }
        }
        return $this->conn;
    }

    public function create($query, $params) {
        try {
            $stmt = $this->getConnection()->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $exception) {
            error_log("Create error: " . $exception->getMessage());
            return false;
        }
    }

    public function read($query, $params) {
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            error_log("Read error: " . $exception->getMessage());
            return [];
        }
    }

    public function update($query, $params) {
        try {
            $stmt = $this->getConnection()->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $exception) {
            error_log("Update error: " . $exception->getMessage());
            return false;
        }
    }

    public function delete($query, $params) {
        try {
            $stmt = $this->getConnection()->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $exception) {
            error_log("Delete error: " . $exception->getMessage());
            return false;
        }
    }

    public function isConnected() {
        return $this->conn !== null;
    }

    public function closeConnection() {
        $this->conn = null;
    }
}
?>
