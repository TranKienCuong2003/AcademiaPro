<?php
// Bao gồm file Database.php để kết nối CSDL
require_once __DIR__ . '/../../Database.php';

// Khởi tạo kết nối CSDL
$database = Database::getInstance(); // Sử dụng phương thức getInstance
$conn = $database->getConnection();

// Kiểm tra nếu có yêu cầu chép môn học
if (isset($_GET['id'])) {
    $course_id = $_GET['id'];

    // Truy vấn lấy thông tin môn học từ CSDL
    $query = "SELECT * FROM courses WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $course_id, PDO::PARAM_INT);
    $stmt->execute();
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra nếu không tìm thấy môn học
    if (!$course) {
        echo "Môn học không tồn tại!";
        exit;
    }
} else {
    echo "Không tìm thấy ID môn học!";
    exit;
}

// Xử lý khi người dùng submit form để tạo bản sao môn học
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $course['course_name'] . " (Sao chép)"; // Thay đổi tên môn học
    $description = $course['description'];
    $credits = $course['credits'];

    // Chèn bản sao môn học vào CSDL
    $insert_query = "INSERT INTO courses (course_name, description, credits) VALUES (:course_name, :description, :credits)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bindParam(':course_name', $name);
    $insert_stmt->bindParam(':description', $description);
    $insert_stmt->bindParam(':credits', $credits, PDO::PARAM_INT);

    if ($insert_stmt->execute()) {
        header('Location: index.php'); // Chuyển hướng về trang danh sách môn học
        exit;
    } else {
        echo "Chép môn học thất bại!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chép Khóa Học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Chép Khóa Học</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label"><strong>Tên Khóa Học:</strong></label>
                <p class="form-control-plaintext"><?php echo htmlspecialchars($course['course_name']); ?></p>
            </div>
            <div class="mb-3">
                <label class="form-label"><strong>Mô Tả Khóa Học:</strong></label>
                <p class="form-control-plaintext"><?php echo htmlspecialchars($course['description']); ?></p>
            </div>
            <div class="mb-3">
                <label class="form-label"><strong>Số Tín Chỉ:</strong></label>
                <p class="form-control-plaintext"><?php echo htmlspecialchars($course['credits']); ?></p>
            </div>
            <button type="submit" class="btn btn-primary">Lưu Bản Sao</button>
            <a href="index.php" class="btn btn-secondary">Quay Lại</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
