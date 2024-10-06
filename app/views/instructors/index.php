<?php
session_start();
require_once '../../../config.php';
require_once '../../models/Instructor.php';

$database = new Database();
$conn = $database->getConnection();
$instructor = new Instructor($conn);

// Xử lý tìm kiếm
$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

// Lấy danh sách giảng viên
$query = "SELECT id, name, subject_taught, degree FROM instructors WHERE name LIKE :search";
$stmt = $conn->prepare($query);
$searchParam = "%" . $search . "%"; // Thêm ký tự wildcard để tìm kiếm
$stmt->bindParam(':search', $searchParam);
$stmt->execute();
$instructors = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Quản lý Giảng viên</title>
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/3595/3595030.png">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/public/index.php">
                <img src="https://cdn-icons-png.flaticon.com/512/3595/3595030.png" alt="Logo" style="height: 40px; width: auto;">
                AcademiaPro
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/app/views/instructors/index.php">Quản lý Giảng viên</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/app/views/students/index.php">Quản lý Sinh viên</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/app/views/courses/index.php">Quản lý Môn học</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/app/views/grade/index.php">Quản lý Điểm thi</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Danh sách Giảng viên</h1>
        
        <!-- Hiển thị thông báo nếu có -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['message']); ?></div>
            <?php unset($_SESSION['message']); ?> <!-- Xóa thông báo sau khi đã hiển thị -->
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
            <?php unset($_SESSION['error']); ?> <!-- Xóa thông báo sau khi đã hiển thị -->
        <?php endif; ?>

        <!-- Form tìm kiếm -->
        <form action="" method="post" class="mb-3">
            <div class="form-group">
                <input type="text" class="form-control" name="search" placeholder="Tìm kiếm giảng viên..." value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <button class="btn btn-primary" type="submit" name="search_button">Tìm</button> <!-- Nút tìm kiếm -->
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã giảng viên</th>
                    <th>Tên Giảng viên</th>
                    <th>Môn học giảng dạy</th>
                    <th>Bằng cấp</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($instructors as $instructor): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($instructor['id']); ?></td>
                        <td><?php echo htmlspecialchars($instructor['name']); ?></td>
                        <td><?php echo htmlspecialchars($instructor['subject_taught']); ?></td>
                        <td><?php echo htmlspecialchars($instructor['degree']); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo htmlspecialchars($instructor['id']); ?>" class="btn btn-warning">Chỉnh sửa</a>
                            <a href="delete.php?id=<?php echo htmlspecialchars($instructor['id']); ?>" class="btn btn-danger">Xóa</a> <!-- Bỏ qua xác nhận -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="create.php" class="btn btn-primary">Thêm Giảng viên</a>
    </div>
</body>
</html>
