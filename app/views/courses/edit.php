<?php
// Bao gồm file Database.php để kết nối CSDL
require_once __DIR__ . '/../../Database.php';

// Khởi tạo kết nối CSDL
$database = Database::getInstance(); // Sử dụng phương thức getInstance()
$conn = $database->getConnection();

// Kiểm tra nếu có yêu cầu chỉnh sửa môn học
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

// Xử lý khi người dùng submit form để cập nhật thông tin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Thay đổi từ 'name' thành 'course_name'
    $course_name = $_POST['course_name'];
    $description = $_POST['description'];
    $credits = $_POST['credits'];

    // Cập nhật thông tin môn học
    $update_query = "UPDATE courses SET course_name = :course_name, description = :description, credits = :credits WHERE id = :id";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bindParam(':course_name', $course_name);
    $update_stmt->bindParam(':description', $description);
    $update_stmt->bindParam(':credits', $credits, PDO::PARAM_INT);
    $update_stmt->bindParam(':id', $course_id, PDO::PARAM_INT);

    if ($update_stmt->execute()) {
        echo "Cập nhật môn học thành công!";
        // Kiểm tra xem file index.php có tồn tại không
        if (file_exists(__DIR__ . '/index.php')) {
            header('Location: index.php'); // Chuyển hướng đến trang danh sách môn học
        } else {
            echo "Trang danh sách môn học không tồn tại!";
        }
        exit;
    } else {
        echo "Cập nhật môn học thất bại!";
    }    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa môn học</title>
    <!-- Bao gồm Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Chỉnh sửa môn học</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="course_name" class="form-label">Tên môn học</label>
                <!-- Thay đổi id và name từ 'name' thành 'course_name' -->
                <input type="text" class="form-control" id="course_name" name="course_name" 
                       value="<?php echo isset($course['course_name']) ? htmlspecialchars($course['course_name']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả môn học</label>
                <textarea class="form-control" id="description" name="description" rows="5" required><?php echo isset($course['description']) ? htmlspecialchars($course['description']) : ''; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="credits" class="form-label">Số tín chỉ</label>
                <input type="number" class="form-control" id="credits" name="credits" 
                       value="<?php echo isset($course['credits']) ? htmlspecialchars($course['credits']) : ''; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <!-- Thay đường dẫn thực tế cho trang danh sách môn học -->
            <a href="index.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>

    <!-- Bao gồm Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
