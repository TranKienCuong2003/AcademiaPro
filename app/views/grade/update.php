<?php
require_once __DIR__ . '/../../Database.php';

// Lấy kết nối từ Database
$database = Database::getInstance();
$conn = $database->getConnection();

// Kiểm tra nếu có gửi dữ liệu từ form
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['student_id']) && isset($_POST['grades'])) {
    $studentId = $_POST['student_id'];
    $grades = $_POST['grades'];

    // Cập nhật từng điểm cho từng môn học
    foreach ($grades as $courseId => $grade) {
        $query = "UPDATE grades SET grade = :grade WHERE student_id = :student_id AND course_id = :course_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':grade', $grade);
        $stmt->bindParam(':student_id', $studentId);
        $stmt->bindParam(':course_id', $courseId);
        $stmt->execute();
    }

    // Chuyển hướng về trang chính
    header('Location: index.php');
    exit;
} else {
    // Hiển thị thông báo lỗi nếu không có dữ liệu
    echo '<div style="color: red; font-weight: bold; text-align: center; margin-top: 20px;">';
    echo "Không thể cập nhật điểm. Vui lòng kiểm tra lại.";
    echo '</div>';
}
?>
