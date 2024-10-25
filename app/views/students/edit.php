<?php
session_start(); // Khởi tạo session
require_once __DIR__ . '/../../Database.php';

// Lấy đối tượng Database bằng phương thức singleton
$database = Database::getInstance();
$conn = $database->getConnection(); // Lấy kết nối

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối đến cơ sở dữ liệu không thành công!");
}

// Xử lý yêu cầu sửa sinh viên
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $class = $_POST['class'];
    $major = $_POST['major'];
    $dob = $_POST['dob'];
    $birthplace = $_POST['birthplace'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $avatar = $_POST['avatar'];

    $query = "UPDATE students SET name = :name, class = :class, major = :major, dob = :dob, birthplace = :birthplace, email = :email, phone = :phone, avatar = :avatar WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':class', $class);
    $stmt->bindParam(':major', $major);
    $stmt->bindParam(':dob', $dob);
    $stmt->bindParam(':birthplace', $birthplace);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':avatar', $avatar);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Cập nhật thông tin sinh viên thành công!";
        header("Location: index.php");
        exit();
    } else {
        echo '<div class="alert alert-danger">Có lỗi xảy ra trong quá trình cập nhật thông tin sinh viên.</div>';
    }
}

// Lấy thông tin sinh viên để điền vào form sửa
$id = $_GET['id'];
$query = "SELECT * FROM students WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$student = $stmt->fetch(PDO::FETCH_ASSOC);

// Kiểm tra xem sinh viên có tồn tại không
if (!$student) {
    die("Sinh viên không tồn tại.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin sinh viên <?php echo htmlspecialchars($student['name']); ?></title>
    <link rel="icon" type="image/png" href="/public/assets/imgages/Logo_AcademiaPro.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>
    <?php include '../partials/navbar.php'; ?> <!-- Navbar -->
    <div class="container mt-5">
        <h2>Sửa thông tin sinh viên</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
            <div class="form-group">
                <label for="name">Tên:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $student['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="class">Lớp:</label>
                <input type="text" class="form-control" id="class" name="class" value="<?php echo $student['class']; ?>" required>
            </div>
            <div class="form-group">
                <label for="major">Chuyên ngành:</label>
                <input type="text" class="form-control" id="major" name="major" value="<?php echo $student['major']; ?>" required>
            </div>
            <div class="form-group">
                <label for="dob">Ngày sinh:</label>
                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $student['dob']; ?>" required>
            </div>
            <div class="form-group">
                <label for="birthplace">Nơi sinh:</label>
                <input type="text" class="form-control" id="birthplace" name="birthplace" value="<?php echo $student['birthplace']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $student['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $student['phone']; ?>" required>
            </div>
            <div class="form-group">
                <label for="avatar">Đường dẫn ảnh đại diện:</label>
                <input type="text" class="form-control" id="avatar" name="avatar" value="<?php echo $student['avatar']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật sinh viên</button>
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
