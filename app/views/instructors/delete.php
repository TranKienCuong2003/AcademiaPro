<?php
session_start(); // Bắt đầu phiên làm việc

require_once '../../../config.php';
require_once '../../models/Instructor.php';

$database = new Database();
$conn = $database->getConnection();
$instructor = new Instructor($conn);

// Kiểm tra xem có ID giảng viên được cung cấp không
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Xóa giảng viên
    $query = "DELETE FROM instructors WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Xóa giảng viên thành công";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error'] = "Có lỗi xảy ra khi xóa giảng viên";
        header("Location: index.php");
        exit;
    }
} else {
    $_SESSION['error'] = "ID giảng viên không được cung cấp";
    header("Location: index.php");
    exit;
}
