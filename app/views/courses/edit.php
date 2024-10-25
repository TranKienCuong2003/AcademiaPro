<?php
session_start();

// Bao gồm file Database.php để kết nối CSDL
require_once __DIR__ . '/../../Database.php';

// Khởi tạo kết nối CSDL
$database = Database::getInstance();
$conn = $database->getConnection();

$message = ''; // Biến để lưu thông báo

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
        $message = "Môn học không tồn tại!";
    }
} else {
    $message = "Không tìm thấy ID môn học!";
}

// Xử lý khi người dùng submit form để cập nhật thông tin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = $_POST['course_name'];
    $credits = $_POST['credits'];

    $errors = [];

    // Kiểm tra tên môn học
    if (preg_match('/^[0-9]/', $course_name)) {
        $errors[] = "Tên môn học không được bắt đầu bằng số.";
    }

    // Kiểm tra số tín chỉ
    if ($credits < 1 || $credits > 4) {
        $errors[] = "Số tín chỉ không được vượt quá 4.";
    }

    // Nếu không có lỗi, tiến hành cập nhật môn học
    if (empty($errors)) {
        // Cập nhật thông tin môn học
        $update_query = "UPDATE courses SET course_name = :course_name, credits = :credits WHERE id = :id";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bindParam(':course_name', $course_name);
        $update_stmt->bindParam(':credits', $credits, PDO::PARAM_INT);
        $update_stmt->bindParam(':id', $course_id, PDO::PARAM_INT);

        if ($update_stmt->execute()) {
            $message = "Cập nhật môn học thành công!";
            header('Location: index.php'); // Chuyển hướng về trang index
            exit;
        } else {
            $message = "Cập nhật môn học thất bại!";
        }
    } else {
        $message = implode('<br>', $errors); // Kết hợp các thông báo lỗi thành một chuỗi
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa môn học</title>
    <link rel="icon" type="image/png" href="/public/assets/imgages/Logo_AcademiaPro.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/assets/css/style.css">
    <style>
        .alert {
            display: none; /* Ẩn thông báo mặc định */
        }
    </style>
</head>
<body>
    <?php include '../partials/navbar.php'; ?> <!-- Navbar -->

    <div class="container mt-5">
        <?php if ($message): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert" id="message-alert">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <h2 class="mb-4">Chỉnh sửa môn học</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="course_name" class="form-label">Tên môn học</label>
                <input type="text" class="form-control" id="course_name" name="course_name" 
                       value="<?php echo isset($course['course_name']) ? htmlspecialchars($course['course_name']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="credits" class="form-label">Số tín chỉ</label>
                <input type="number" class="form-control" id="credits" name="credits" 
                       value="<?php echo isset($course['credits']) ? htmlspecialchars($course['credits']) : ''; ?>" min="1" max="4" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="index.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>

    <?php include '../partials/chat.php'; ?> <!-- Chat Bot -->

    <?php include '../partials/footer.php'; ?> <!-- Footer -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hiển thị thông báo nếu có
        const messageAlert = document.getElementById('message-alert');
        if (messageAlert) {
            messageAlert.style.display = 'block'; // Hiện thông báo
            setTimeout(() => {
                messageAlert.style.display = 'none'; // Ẩn thông báo sau 3 giây
            }, 3000);
        }
    </script>
</body>
</html>
