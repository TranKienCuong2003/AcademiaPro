<?php
require_once __DIR__ . '/../Database.php'; // Đảm bảo đường dẫn chính xác

class StudentScoresController {
    private $conn;

    // Constructor để thiết lập kết nối cơ sở dữ liệu
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Hàm để lấy dữ liệu điểm của sinh viên và trả về dưới dạng JSON
    public function getScoresJson($studentId) {
        $query = "
        SELECT 
            s.name AS student_name, 
            c.course_name AS course_name, 
            g.grade
        FROM 
            students s
        JOIN 
            grades g ON s.id = g.student_id
        JOIN 
            courses c ON g.course_id = c.id
        WHERE s.id = :student_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);
        $stmt->execute();
        $grades = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Trả về dữ liệu dưới dạng JSON
        header('Content-Type: application/json');
        if (!empty($grades)) {
            $studentName = $grades[0]['student_name'];
            $courseNames = array_column($grades, 'course_name');
            $courseGrades = array_column($grades, 'grade');
            echo json_encode([
                'student_name' => $studentName,
                'courses' => $courseNames,
                'grades' => $courseGrades
            ]);
        } else {
            // Nếu không có dữ liệu thì trả về JSON trống nhưng hợp lệ
            echo json_encode([
                'student_name' => '',
                'courses' => [],
                'grades' => []
            ]);
        }
    }
}
?>
