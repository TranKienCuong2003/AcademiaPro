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

    // Truy vấn để lấy tên sinh viên trước khi xóa
    $name_query = "SELECT name FROM students WHERE id = :id";
    $name_stmt = $conn->prepare($name_query);
    $name_stmt->bindParam(':id', $delete_id);
    $name_stmt->execute();
    $student = $name_stmt->fetch(PDO::FETCH_ASSOC);

    if ($student) {
        // Truy vấn để xóa sinh viên
        $delete_query = "DELETE FROM students WHERE id = :id";
        $stmt = $conn->prepare($delete_query);
        $stmt->bindParam(':id', $delete_id);

        if ($stmt->execute()) {
            // Lưu thông báo vào session
            $_SESSION['message'] = "Xóa sinh viên <strong>" . htmlspecialchars($student['name']) . "</strong> thành công!";
            // Chuyển hướng về danh sách sinh viên
            header("Location: index.php");
            exit();
        } else {
            echo '<div class="alert alert-danger">Có lỗi xảy ra trong quá trình xóa sinh viên.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Không tìm thấy sinh viên với ID: ' . htmlspecialchars($delete_id) . '</div>';
    }
}

// Phân trang
$limit = 5; // Số lượng sinh viên trên mỗi trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Lấy số trang từ URL
$offset = ($page - 1) * $limit; // Tính chỉ số bắt đầu

// Lấy tổng số sinh viên
$total_query = "SELECT COUNT(*) FROM students";
$total_stmt = $conn->prepare($total_query);
$total_stmt->execute();
$total_students = $total_stmt->fetchColumn();
$total_pages = ceil($total_students / $limit); // Tính tổng số trang

// Lấy danh sách sinh viên theo trang
$query = "SELECT * FROM students LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($query);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sinh viên</title>
    <link rel="icon" type="image/png" href="/public/assets/imgages/Logo_AcademiaPro.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>
    <?php include '../partials/navbar.php'; ?> <!-- Navbar -->
    
    <div class="container mt-5">
        <!-- Thông báo nếu có -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <h2>Danh sách sinh viên</h2>

        <div class="table-responsive">
            <table class="table table-dark table-bordered">
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
                        <?php foreach ($students as $index => $student): ?>
                            <tr style="background-color: <?php echo ($index % 2 == 0) ? '#ffffff' : '#d4edda'; ?>">
                                <td class="text-dark"><?php echo htmlspecialchars($student['id']); ?></td>
                                <td class="text-dark"><?php echo htmlspecialchars($student['name']); ?></td>
                                <td class="text-dark"><?php echo htmlspecialchars($student['class']); ?></td>
                                <td class="text-dark"><?php echo htmlspecialchars($student['major']); ?></td>
                                <td class="text-dark"><?php
                                    $dob = new DateTime($student['dob']);
                                    echo htmlspecialchars($dob->format('d/m/Y')); 
                                ?></td>
                                <td class="text-dark"><?php echo htmlspecialchars($student['birthplace']); ?></td>
                                <td>
                                    <a href="view.php?id=<?php echo htmlspecialchars($student['id']); ?>" class="btn btn-info">Chi tiết</a>
                                    <a href="edit.php?id=<?php echo htmlspecialchars($student['id']); ?>" class="btn btn-warning">Sửa</a>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo htmlspecialchars($student['id']); ?>">Xóa</button>

                                    <!-- Modal xác nhận xóa -->
                                    <div class="modal fade" id="deleteModal<?php echo htmlspecialchars($student['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?php echo htmlspecialchars($student['id']); ?>" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel<?php echo htmlspecialchars($student['id']); ?>">Xóa sinh viên</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" style="color: black;">
                                                    Bạn có chắc chắn muốn xóa vĩnh viễn <strong><?php echo htmlspecialchars($student['name']); ?></strong> không?
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="" method="POST">
                                                        <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($student['id']); ?>">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
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
                    <tr>
                        <td colspan="7" class="text-center">Không có sinh viên nào.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Nút Thêm sinh viên -->
        <div class="d-flex justify-content-between mt-4">
            <a href="../students/create.php" class="btn btn-primary">Thêm sinh viên</a>
        </div>

        <!-- Phân trang -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo ($page == 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo ($page > 1) ? '?page=' . ($page - 1) : '#'; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i === $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?php echo ($page == $total_pages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo ($page < $total_pages) ? '?page=' . ($page + 1) : '#'; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <?php include '../partials/footer.php'; ?> <!-- Footer -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
