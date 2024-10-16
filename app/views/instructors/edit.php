<?php
session_start();
require_once '../../../config.php';
require_once '../../models/Instructor.php';

$database = new Database();
$conn = $database->getConnection();
$instructor = new Instructor($conn);

// Kiểm tra xem có ID giảng viên được cung cấp không
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Lấy thông tin giảng viên
    $query = "SELECT id, name, subject_taught, degree FROM instructors WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $instructorData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra xem giảng viên có tồn tại không
    if (!$instructorData) {
        $_SESSION['error'] = "Giảng viên không tồn tại.";
        header("Location: index.php");
        exit;
    }
} else {
    $_SESSION['error'] = "ID giảng viên không được cung cấp.";
    header("Location: index.php");
    exit;
}

// Xử lý việc cập nhật thông tin giảng viên
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $subject_taught = trim($_POST['subject_taught']);
    $degree = trim($_POST['degree']);

    // Cập nhật thông tin giảng viên
    if ($instructor->updateInstructor($id, $name, $subject_taught, $degree)) {
        $_SESSION['message'] = "Cập nhật giảng viên thành công.";
        header("Location: index.php");
        exit;
    } else {
        $error = "Có lỗi xảy ra khi cập nhật giảng viên.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa giảng viên</title>
    <link rel="icon" type="image/png" href="/public/assets/imgages/Logo_AcademiaPro.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>
    <?php include '../partials/navbar.php'; ?> <!-- Navbar -->
    <div class="container mt-5">
        <h1>Chỉnh sửa Giảng viên</h1>
        <!-- Hiển thị thông báo lỗi nếu có -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="form-group">
                <label for="name">Tên Giảng viên:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($instructorData['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="subject_taught">Môn học giảng dạy:</label>
                <input type="text" class="form-control" id="subject_taught" name="subject_taught" value="<?php echo htmlspecialchars($instructorData['subject_taught']); ?>" required>
            </div>
            <div class="form-group">
                <label for="degree">Bằng cấp:</label>
                <input type="text" class="form-control" id="degree" name="degree" value="<?php echo htmlspecialchars($instructorData['degree']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="index.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>

    <?php include '../partials/footer.php'; ?> <!-- Footer -->
</body>
</html>
