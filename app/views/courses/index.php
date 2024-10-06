<?php
require_once '../../../config.php';
require_once '../../models/Course.php';

// Khởi tạo đối tượng Database
$database = new Database();
$db = $database->getConnection(); // Lấy kết nối

// Kiểm tra xem biến $db đã được khởi tạo chưa
if (!$db) {
    die("Database connection not established.");
}

// Tạo một đối tượng Course
$courseModel = new Course($db);

// Xử lý xóa môn học
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    if ($courseModel->deleteCourse($delete_id)) {
        echo "<div class='alert alert-success'>Môn học đã được xóa thành công.</div>";
    } else {
        echo "<div class='alert alert-danger'>Xóa môn học không thành công.</div>";
    }
}

// Xử lý tìm kiếm
$searchTerm = '';
if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];
}

// Lấy danh sách môn học với tìm kiếm
$courses = $courseModel->getCourses($searchTerm); // Điều chỉnh ở đây để xử lý tham số tìm kiếm
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách môn học</title>
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/3595/3595030.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        <h1 class="mb-4">Danh sách môn học</h1>
        
        <form method="POST" class="mb-4">
            <input type="text" name="search" class="form-control" placeholder="Tìm môn học..." value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button type="submit" class="btn btn-primary mt-2">Tìm kiếm</button>
        </form>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mã môn học</th>
                    <th>Tên môn học</th>
                    <th>Mô tả</th>
                    <th>Tín chỉ</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($courses) > 0): ?>
                    <?php foreach ($courses as $course): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($course['id']); ?></td>
                            <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                            <td><?php echo htmlspecialchars($course['description']); ?></td>
                            <td><?php echo htmlspecialchars($course['credits']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $course['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                                <a href="copy.php?id=<?php echo $course['id']; ?>" class="btn btn-info btn-sm">Chép</a>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDeleteModal" data-id="<?php echo $course['id']; ?>">Xóa</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Không có môn học nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal xác nhận xóa -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa môn học này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <a href="#" id="confirmDeleteButton" class="btn btn-danger">Xóa</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Xử lý sự kiện khi modal mở
        $('#confirmDeleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Nút "Xóa" được nhấn
            var id = button.data('id'); // Lấy ID môn học

            // Cập nhật liên kết xóa vào nút trong modal
            var deleteUrl = "?delete_id=" + id;
            $('#confirmDeleteButton').attr('href', deleteUrl);
        });
    </script>
</body>
</html>
