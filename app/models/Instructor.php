<?php
class Instructor {
    private $conn;

    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // Phương thức lấy danh sách giảng viên
    public function getInstructors($searchTerm = '') {
        // Tạo truy vấn SQL
        $query = "SELECT * FROM instructors";

        // Nếu có từ khóa tìm kiếm, thêm điều kiện vào truy vấn
        if (!empty($searchTerm)) {
            $query .= " WHERE name LIKE :searchTerm OR subject_taught LIKE :searchTerm OR degree LIKE :searchTerm";
        }

        // Chuẩn bị truy vấn
        $stmt = $this->conn->prepare($query);

        // Ràng buộc tham số tìm kiếm
        if (!empty($searchTerm)) {
            $searchTerm = "%$searchTerm%"; // Thêm ký tự % để tìm kiếm
            $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
        }
        
        $stmt->execute();

        // Lấy kết quả
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Phương thức thêm giảng viên
    public function createInstructor($name, $subject_taught, $degree) {
        $query = "INSERT INTO instructors (name, subject_taught, degree) VALUES (:name, :subject_taught, :degree)";
        $stmt = $this->conn->prepare($query);

        // Ràng buộc tham số
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':subject_taught', $subject_taught);
        $stmt->bindParam(':degree', $degree);

        // Thực thi truy vấn
        return $stmt->execute();
    }

    // Phương thức cập nhật giảng viên
    public function updateInstructor($id, $name, $subject_taught, $degree) {
        $query = "UPDATE instructors SET name = :name, subject_taught = :subject_taught, degree = :degree WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Ràng buộc tham số
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':subject_taught', $subject_taught);
        $stmt->bindParam(':degree', $degree);

        // Thực thi truy vấn
        return $stmt->execute();
    }

    // Phương thức xóa giảng viên
    public function deleteInstructor($id) {
        $query = "DELETE FROM instructors WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Ràng buộc tham số
        $stmt->bindParam(':id', $id);

        // Thực thi truy vấn
        return $stmt->execute();
    }

    // Phương thức lấy thông tin giảng viên theo ID
    public function getInstructorById($id) {
        $query = "SELECT * FROM instructors WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Ràng buộc tham số
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
