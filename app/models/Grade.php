<?php
// Import file Database.php để sử dụng kết nối cơ sở dữ liệu
require_once __DIR__ . '/../config/Database.php';

class Grade {
    private $conn; // Thuộc tính để lưu kết nối cơ sở dữ liệu

    // Constructor để khởi tạo đối tượng và thiết lập kết nối cơ sở dữ liệu
    public function __construct() {
        // Lấy kết nối từ class Database
        $this->conn = (new Database())->getConnection();
    }

    // Phương thức để lấy tất cả bản ghi từ bảng 'grades'
    public function getAllGrades() {
        // Câu truy vấn để lấy tất cả dữ liệu từ bảng 'grades'
        $query = "SELECT * FROM grades";
        // Chuẩn bị câu truy vấn
        $stmt = $this->conn->prepare($query);
        // Thực thi câu truy vấn
        $stmt->execute();
        // Trả về tất cả các dòng kết quả dưới dạng mảng kết hợp
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Phương thức để lấy thông tin một bản ghi cụ thể từ bảng 'grades' theo id
    public function getGradeById($id) {
        // Câu truy vấn để lấy bản ghi có id tương ứng
        $query = "SELECT * FROM grades WHERE id = :id";
        // Chuẩn bị câu truy vấn
        $stmt = $this->conn->prepare($query);
        // Gán giá trị tham số id vào câu truy vấn
        $stmt->bindParam(':id', $id);
        // Thực thi câu truy vấn
        $stmt->execute();
        // Trả về bản ghi đầu tiên dưới dạng mảng kết hợp
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Phương thức để thêm mới một bản ghi vào bảng 'grades'
    public function createGrade($data) {
        // Câu truy vấn để chèn một bản ghi mới vào bảng 'grades'
        $query = "INSERT INTO grades (student_id, course_id, grade, semester, exam_date) VALUES (:student_id, :course_id, :grade, :semester, :exam_date)";
        // Chuẩn bị câu truy vấn
        $stmt = $this->conn->prepare($query);
        // Gán giá trị cho các tham số của câu truy vấn
        $stmt->bindParam(':student_id', $data['student_id']);
        $stmt->bindParam(':course_id', $data['course_id']);
        $stmt->bindParam(':grade', $data['grade']);
        $stmt->bindParam(':semester', $data['semester']);
        $stmt->bindParam(':exam_date', $data['exam_date']);
        // Thực thi câu truy vấn và trả về kết quả (true/false)
        return $stmt->execute();
    }

    // Phương thức để cập nhật một bản ghi trong bảng 'grades' theo id
    public function updateGrade($id, $data) {
        // Câu truy vấn để cập nhật bản ghi có id tương ứng
        $query = "UPDATE grades SET student_id = :student_id, course_id = :course_id, grade = :grade, semester = :semester, exam_date = :exam_date WHERE id = :id";
        // Chuẩn bị câu truy vấn
        $stmt = $this->conn->prepare($query);
        // Gán giá trị cho các tham số của câu truy vấn
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':student_id', $data['student_id']);
        $stmt->bindParam(':course_id', $data['course_id']);
        $stmt->bindParam(':grade', $data['grade']);
        $stmt->bindParam(':semester', $data['semester']);
        $stmt->bindParam(':exam_date', $data['exam_date']);
        // Thực thi câu truy vấn và trả về kết quả (true/false)
        return $stmt->execute();
    }

    // Phương thức để xóa một bản ghi trong bảng 'grades' theo id
    public function deleteGrade($id) {
        // Câu truy vấn để xóa bản ghi có id tương ứng
        $query = "DELETE FROM grades WHERE id = :id";
        // Chuẩn bị câu truy vấn
        $stmt = $this->conn->prepare($query);
        // Gán giá trị tham số id vào câu truy vấn
        $stmt->bindParam(':id', $id);
        // Thực thi câu truy vấn và trả về kết quả (true/false)
        return $stmt->execute();
    }
}
?>
