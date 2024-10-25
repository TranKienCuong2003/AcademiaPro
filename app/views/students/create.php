<?php
session_start(); // Khởi tạo session
require_once __DIR__ . '/../../Database.php';

// Tạo đối tượng Database bằng phương thức singleton
$database = Database::getInstance();
$conn = $database->getConnection(); // Lấy kết nối

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối đến cơ sở dữ liệu không thành công!");
}

// Xử lý yêu cầu thêm sinh viên
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $class = $_POST['class'];
    $major = $_POST['major'];
    $dob = $_POST['dob'];
    $birthplace = $_POST['birthplace'];
    $avatar = $_POST['avatar'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $query = "INSERT INTO students (name, class, major, dob, birthplace, avatar, phone, email) 
              VALUES (:name, :class, :major, :dob, :birthplace, :avatar, :phone, :email)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':class', $class);
    $stmt->bindParam(':major', $major);
    $stmt->bindParam(':dob', $dob);
    $stmt->bindParam(':birthplace', $birthplace);
    $stmt->bindParam(':avatar', $avatar);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':email', $email);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Thêm sinh viên thành công!";
        header("Location: index.php");
        exit();
    } else {
        echo '<div class="alert alert-danger">Có lỗi xảy ra trong quá trình thêm sinh viên.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sinh viên</title>
    <link rel="icon" type="image/png" href="/public/assets/imgages/Logo_AcademiaPro.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>
    <?php include '../partials/navbar.php'; ?> <!-- Navbar -->
    <div class="container mt-5">
        <h2>Thêm sinh viên</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Tên:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="class">Lớp:</label>
                <input type="text" class="form-control" id="class" name="class" required>
            </div>
            <div class="form-group">
                <label for="major">Chuyên ngành:</label>
                <input type="text" class="form-control" id="major" name="major" required>
            </div>
            <div class="form-group">
                <label for="dob">Ngày sinh:</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>
            <div class="form-group">
                <label for="birthplace">Nơi sinh:</label>
                <input type="text" class="form-control" id="birthplace" name="birthplace" required>
            </div>
            <div class="form-group">
                <label for="avatar">Ảnh đại diện (URL):</label>
                <input type="url" class="form-control" id="avatar" name="avatar" required>
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm sinh viên</button>
            <a href="index.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>

    <?php include '../partials/chat.php'; ?> <!-- Chat Bot -->

    <?php include '../partials/footer.php'; ?> <!-- Footer -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
