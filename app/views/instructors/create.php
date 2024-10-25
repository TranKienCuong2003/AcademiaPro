<?php
session_start();
require_once '../../../config.php';
require_once '../../models/Instructor.php';

$database = new Database();
$conn = $database->getConnection();
$instructor = new Instructor($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $name = trim($_POST['name']);
    $subject_taught = trim($_POST['subject_taught']);
    $degree = trim($_POST['degree']);
    $avatar = trim($_POST['avatar']);
    $date_of_birth = $_POST['date_of_birth'];
    $hometown = trim($_POST['hometown']);
    $current_address = trim($_POST['current_address']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    // Kiểm tra nếu tất cả các trường đều được điền
    if (
        !empty($name) && !empty($subject_taught) && !empty($degree) &&
        !empty($avatar) && !empty($date_of_birth) &&
        !empty($hometown) && !empty($current_address) &&
        !empty($phone) && !empty($email)
    ) {
        // Thêm giảng viên vào cơ sở dữ liệu
        if ($instructor->createInstructor($name, $subject_taught, $degree, $avatar, $date_of_birth, $hometown, $current_address, $phone, $email)) {
            $_SESSION['message'] = "Thêm giảng viên thành công!";
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Có lỗi xảy ra. Vui lòng thử lại.";
        }
    } else {
        $error_message = "Vui lòng điền đầy đủ thông tin.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm giảng viên</title>
    <link rel="icon" type="image/png" href="/public/assets/imgages/Logo_AcademiaPro.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>
    <?php include '../partials/navbar.php'; ?> <!-- Navbar -->
    <div class="container mt-5">
        <h1>Thêm giảng viên</h1>

        <!-- Hiển thị thông báo lỗi nếu có -->
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="name">Tên Giảng viên:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="subject_taught">Môn học giảng dạy:</label>
                <input type="text" name="subject_taught" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="degree">Bằng cấp:</label>
                <input type="text" name="degree" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="avatar">Đường dẫn ảnh (Avatar):</label>
                <input type="text" name="avatar" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="date_of_birth">Ngày sinh:</label>
                <input type="date" name="date_of_birth" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="hometown">Quê quán:</label>
                <input type="text" name="hometown" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="current_address">Địa chỉ hiện tại:</label>
                <input type="text" name="current_address" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm Giảng viên</button>
            <a href="index.php" class="btn btn-secondary">Trở về</a>
        </form>
    </div>

    <?php include '../partials/chat.php'; ?> <!-- Chat Bot -->

    <?php include '../partials/footer.php'; ?> <!-- Footer -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
