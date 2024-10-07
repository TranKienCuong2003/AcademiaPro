<?php
session_start(); // Khởi tạo session
require_once __DIR__ . '/../../Database.php';

// Lấy instance của lớp Database
$database = Database::getInstance();
$conn = $database->getConnection(); // Lấy kết nối

// Kiểm tra xem có nhận được kết nối hay không
if (!$conn) {
    die("Kết nối đến cơ sở dữ liệu không thành công!");
}

// Kiểm tra yêu cầu xóa sinh viên
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    // Truy vấn để xóa sinh viên
    $delete_query = "DELETE FROM students WHERE id = :id";
    $stmt = $conn->prepare($delete_query);
    $stmt->bindParam(':id', $delete_id);

    if ($stmt->execute()) {
        // Lưu thông báo vào session
        $_SESSION['message'] = "Xóa sinh viên thành công!";
        // Chuyển hướng về danh sách sinh viên
        header("Location: index.php");
        exit();
    } else {
        echo '<div class="alert alert-danger">Có lỗi xảy ra trong quá trình xóa sinh viên.</div>';
    }
}

// Lấy danh sách sinh viên
$query = "SELECT * FROM students";
$stmt = $conn->prepare($query);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Quản lý sinh viên</title>
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/3595/3595030.png">
</head>
<body>
    <div class="container mt-5">
        <h2>Danh sách sinh viên</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Mã sinh viên</th>
                    <th>Họ và tên</th>
                    <th>Lớp</th>
                    <th>Chuyên ngành</th>
                    <th>Ngày sinh</th>
                    <th>Nơi sinh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($students) && $students): ?>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['id']); ?></td>
                            <td><?php echo htmlspecialchars($student['name']); ?></td>
                            <td><?php echo htmlspecialchars($student['class']); ?></td>
                            <td><?php echo htmlspecialchars($student['major']); ?></td>
                            <td><?php echo htmlspecialchars($student['dob']); ?></td>
                            <td><?php echo htmlspecialchars($student['birthplace']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo htmlspecialchars($student['id']); ?>" class="btn btn-warning">Sửa</a>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo htmlspecialchars($student['id']); ?>">Xóa</button>

                                <!-- Modal xác nhận xóa -->
                                <div class="modal fade" id="deleteModal<?php echo htmlspecialchars($student['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa sinh viên? <strong><?php echo htmlspecialchars($student['name']); ?></strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                                <form method="POST" action="">
                                                    <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($student['id']); ?>">
                                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center">Không có sinh viên nào</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="create.php" class="btn btn-primary mb-3">Thêm sinh viên</a>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($_SESSION['message']); ?>
                <?php unset($_SESSION['message']); // Xóa thông báo sau khi đã hiển thị ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
