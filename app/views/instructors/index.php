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

// Lấy số lượng giảng viên
$queryCount = "SELECT COUNT(*) FROM instructors WHERE name LIKE :search";
$stmtCount = $conn->prepare($queryCount);
$searchParam = "%" . $search . "%"; // Thêm ký tự wildcard để tìm kiếm
$stmtCount->bindParam(':search', $searchParam);
$stmtCount->execute();
$totalInstructors = $stmtCount->fetchColumn();

// Phân trang
$limit = 5; // Số giảng viên mỗi trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Tính số trang
$totalPages = max(1, ceil($totalInstructors / $limit));

// Lấy danh sách giảng viên theo trang
$query = "SELECT id, name, subject_taught, degree FROM instructors WHERE name LIKE :search LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($query);
$stmt->bindParam(':search', $searchParam);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$instructors = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Giảng viên</title>
    <link rel="icon" type="image/png" href="/public/assets/imgages/Logo_AcademiaPro.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>
    <?php include '../partials/navbar.php'; ?> <!-- Navbar -->
    <div class="container mt-5">
        <h1 class="mb-4">Danh sách giảng viên</h1>
        
        <!-- Hiển thị thông báo nếu có -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['message']); ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Form tìm kiếm -->
        <form action="" method="post" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Tìm kiếm giảng viên..." value="<?php echo htmlspecialchars($search); ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" name="search_button">Tìm</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-dark table-bordered">
                <thead>
                    <tr>
                        <th class="text-light">Mã giảng viên</th>
                        <th class="text-light">Tên Giảng viên</th>
                        <th class="text-light">Môn học giảng dạy</th>
                        <th class="text-light">Bằng cấp</th>
                        <th class="text-light">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($instructors as $index => $instructor): ?>
                        <tr style="background-color: <?php echo ($index % 2 == 0) ? '#ffffff' : '#d4edda'; ?>">
                            <td class="text-dark"><?php echo htmlspecialchars($instructor['id']); ?></td>
                            <td class="text-dark"><?php echo htmlspecialchars($instructor['name']); ?></td>
                            <td class="text-dark"><?php echo htmlspecialchars($instructor['subject_taught']); ?></td>
                            <td class="text-dark"><?php echo htmlspecialchars($instructor['degree']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo htmlspecialchars($instructor['id']); ?>" class="btn btn-warning">Chỉnh sửa</a>
                                <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $instructor['id']; ?>">Xóa</button>
                            </td>
                        </tr>

                        <!-- Modal xác nhận xóa -->
                        <div class="modal fade" id="deleteModal<?php echo $instructor['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn muốn xóa giảng viên <strong><?php echo htmlspecialchars($instructor['name']); ?></strong> không?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                        <a href="delete.php?id=<?php echo htmlspecialchars($instructor['id']); ?>" class="btn btn-danger">Xóa</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <a href="create.php" class="btn btn-primary">Thêm Giảng viên</a>

        <!-- Phân trang -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo ($page == 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo ($page > 1) ? '?page=' . ($page - 1) . '&search=' . urlencode($search) : '#'; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($i === $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?php echo ($page == $totalPages || $totalPages == 0) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo ($page < $totalPages) ? '?page=' . ($page + 1) . '&search=' . urlencode($search) : '#'; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <?php include '../partials/footer.php'; ?> <!-- Footer -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
