<?php
session_start();
require_once '../../../config.php';
require_once '../../models/Course.php';

// Khởi tạo đối tượng Database
$database = new Database();
$db = $database->getConnection();

// Kiểm tra kết nối
if (!$db) {
    die("Database connection not established.");
}

// Tạo đối tượng Course
$courseModel = new Course($db);

// Xử lý tìm kiếm
$searchTerm = '';
if (isset($_POST['search'])) {
    $searchTerm = htmlspecialchars(trim($_POST['search']));
}

// Lấy danh sách môn học với tìm kiếm
$courses = $courseModel->getCourses($searchTerm);

// Phân trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5; 
$total_courses = count($courses); 
$total_pages = ceil($total_courses / $limit);

// Lấy danh sách môn học cho trang hiện tại
$courses = array_slice($courses, ($page - 1) * $limit, $limit);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách môn học</title>
    <link rel="icon" type="image/png" href="/public/assets/imgages/Logo_AcademiaPro.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>
    <?php 
        // Xử lý xóa môn học
        if (isset($_POST['delete_id'])) {
            $delete_id = $_POST['delete_id'];
            if ($courseModel->deleteCourse($delete_id)) {
                echo "<div class='alert alert-success'>Môn học đã được xóa thành công.</div>";
            } else {
                echo "<div class='alert alert-danger'>Xóa môn học không thành công.</div>";
            }
        }
    ?>
    
    <?php include '../partials/navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-4">Danh sách môn học</h1>

        <form method="POST" class="mb-4 d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Tìm môn học..." value="<?php echo htmlspecialchars($searchTerm); ?>" style="flex-grow: 1;">
            <button type="submit" class="btn btn-primary">Tìm</button>
        </form>

        <div class="table-responsive">
            <table class="table table-dark table-bordered">
                <thead>
                    <tr>
                        <th class="text-light">Mã môn học</th>
                        <th class="text-light">Tên môn học</th>
                        <th class="text-light">Số tín chỉ</th>
                        <th class="text-light">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($courses)): ?>
                        <?php foreach ($courses as $index => $course): ?>
                            <tr style="background-color: <?php echo ($index % 2 == 0) ? '#ffffff' : '#d4edda'; ?>">
                                <td class="text-dark"><?php echo htmlspecialchars($course['id']); ?></td>
                                <td class="text-dark"><?php echo htmlspecialchars($course['course_name']); ?></td>
                                <td class="text-dark"><?php echo htmlspecialchars($course['credits']); ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo htmlspecialchars($course['id']); ?>" class="btn btn-warning">Chỉnh sửa</a>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo htmlspecialchars($course['id']); ?>">Xóa</button>

                                    <!-- Modal xác nhận xóa -->
                                    <div class="modal fade" id="deleteModal<?php echo htmlspecialchars($course['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?php echo htmlspecialchars($course['id']); ?>" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel<?php echo htmlspecialchars($course['id']); ?>">Xác nhận xóa môn học</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-dark">
                                                    Bạn có chắc chắn muốn xóa môn học <strong><?php echo htmlspecialchars($course['course_name']); ?></strong> với mã <strong><?php echo htmlspecialchars($course['id']); ?></strong> không?
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="POST">
                                                        <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($course['id']); ?>">
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
                            <td colspan="4" class="text-center">Không có môn học nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="text mb-4">
            <a href="../../views/courses/create.php" class="btn btn-primary">Thêm môn học</a>
        </div>

        <!-- Phân trang -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo ($page == 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo max(1, $page - 1); ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i === $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?php echo ($page == $total_pages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo min($total_pages, $page + 1); ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <?php include '../partials/chat.php'; ?> <!-- Chat Bot -->

    <?php include '../partials/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
