<?php
require_once __DIR__ . '/../../controllers/StudentScoresController.php';

// Lấy ID sinh viên từ query string
$studentId = isset($_GET['student_id']) ? (int)$_GET['student_id'] : 0;

// Tạo một instance của controller và gọi hàm getScoresJson
$controller = new StudentScoresController();
$controller->getScoresJson($studentId);
?>
