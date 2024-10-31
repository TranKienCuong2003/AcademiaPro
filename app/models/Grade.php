<?php
require_once __DIR__ . '/../core/Database.php';

class Grade {
    private $conn;

    // Constructor để khởi tạo đối tượng và thiết lập kết nối cơ sở dữ liệu
    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    // Phương thức để lấy tất cả bản ghi từ bảng 'grades'
    public function getAllGrades() {
        $query = "SELECT * FROM grades";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Phương thức để lấy thông tin một bản ghi cụ thể từ bảng 'grades' theo id
    public function getGradeById($id) {
        $query = "SELECT * FROM grades WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Phương thức để thêm mới một bản ghi vào bảng 'grades'
    public function createGrade($data) {
        $query = "INSERT INTO grades (student_id, course_id, grade, semester, exam_date) VALUES (:student_id, :course_id, :grade, :semester, :exam_date)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $data['student_id']);
        $stmt->bindParam(':course_id', $data['course_id']);
        $stmt->bindParam(':grade', $data['grade']);
        $stmt->bindParam(':semester', $data['semester']);
        $stmt->bindParam(':exam_date', $data['exam_date']);
        return $stmt->execute();
    }

    // Phương thức để cập nhật một bản ghi trong bảng 'grades' theo id
    public function updateGrade($id, $data) {
        $query = "UPDATE grades SET student_id = :student_id, course_id = :course_id, grade = :grade, semester = :semester, exam_date = :exam_date WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':student_id', $data['student_id']);
        $stmt->bindParam(':course_id', $data['course_id']);
        $stmt->bindParam(':grade', $data['grade']);
        $stmt->bindParam(':semester', $data['semester']);
        $stmt->bindParam(':exam_date', $data['exam_date']);
        return $stmt->execute();
    }

    // Phương thức để xóa một bản ghi trong bảng 'grades' theo id
    public function deleteGrade($id) {
        $query = "DELETE FROM grades WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
