<?php
class Instructor {
    // Kết nối cơ sở dữ liệu và tên bảng
    private $conn;
    private $table_name = "instructors";

    // Các thuộc tính của giảng viên
    public $id;
    public $name;
    public $subject_taught;
    public $degree;

    // Constructor với đối tượng kết nối
    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy tất cả giảng viên
    public function getInstructors() {
        $query = "SELECT id, name, subject_taught, degree FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm giảng viên mới
    public function createInstructor($name, $subject_taught, $degree) {
        $query = "INSERT INTO " . $this->table_name . " (name, subject_taught, degree) VALUES (:name, :subject_taught, :degree)";
        $stmt = $this->conn->prepare($query);

        // Liên kết các tham số
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':subject_taught', $subject_taught);
        $stmt->bindParam(':degree', $degree);

        // Thực hiện truy vấn
        return $stmt->execute();
    }

    // Cập nhật thông tin giảng viên
    public function updateInstructor($id, $name, $subject_taught, $degree) {
        $query = "UPDATE " . $this->table_name . " SET name = :name, subject_taught = :subject_taught, degree = :degree WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Liên kết các tham số
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':subject_taught', $subject_taught);
        $stmt->bindParam(':degree', $degree);

        // Thực hiện truy vấn
        return $stmt->execute();
    }

    // Xóa giảng viên
    public function deleteInstructor($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Liên kết tham số
        $stmt->bindParam(':id', $id);

        // Thực hiện truy vấn
        return $stmt->execute();
    }

    // Tìm kiếm giảng viên theo tên
    public function searchInstructors($name) {
        $query = "SELECT id, name, subject_taught, degree FROM " . $this->table_name . " WHERE name LIKE :name";
        $stmt = $this->conn->prepare($query);

        // Liên kết tham số
        $name = "%$name%";
        $stmt->bindParam(':name', $name);

        // Thực hiện truy vấn
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
