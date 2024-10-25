<?php
session_start();
require_once '../../../config.php';
require_once '../../models/Course.php';

// Khởi tạo đối tượng Database
$database = new Database();
$db = $database->getConnection();

// Kiểm tra xem biến $db đã được khởi tạo chưa
if (!$db) {
    die("Database connection not established.");
}

// Tạo một đối tượng Course
$courseModel = new Course($db);

// Xử lý lưu môn học mới
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_name = htmlspecialchars(trim($_POST['course_name']));
    $credits = htmlspecialchars(trim($_POST['credits']));

    $errors = [];

    // Kiểm tra tên môn học
    if (preg_match('/^[0-9]/', $course_name)) {
        $errors[] = "Tên môn học không được bắt đầu bằng số.";
    }

    // Kiểm tra số tín chỉ
    if ($credits < 1 || $credits > 4) {
        $errors[] = "Số tín chỉ phải nằm trong khoảng từ 1 đến 4.";
    }

    // Nếu không có lỗi, tiến hành thêm môn học
    if (empty($errors)) {
        if ($courseModel->createCourse($course_name, $credits)) {
            header("Location: index.php"); // Chuyển hướng về trang index
            exit(); // Dừng thực thi script
        } else {
            echo "<div class='alert alert-danger'>Thêm môn học không thành công.</div>";
        }
    } else {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm môn học</title>
    <link rel="icon" type="image/png" href="/public/assets/imgages/Logo_AcademiaPro.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>
    <?php include '../partials/navbar.php'; ?> <!-- Navbar -->
    <div class="container mt-5">
        <h1 class="mb-4">Thêm môn học</h1>
        
        <form method="POST" class="mb-4">
            <div class="form-group">
                <label for="course_name">Tên môn học</label>
                <input type="text" name="course_name" id="course_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="credits">Số tín chỉ</label>
                <input type="number" name="credits" id="credits" class="form-control" min="1" max="4" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm môn học</button>
            <a href="index.php" class="btn btn-secondary">Trở lại</a>
        </form>
    </div>

    <?php include '../partials/chat.php'; ?> <!-- Chat Bot -->

    <?php include '../partials/footer.php'; ?> <!-- Include Footer -->
</body>
</html>
