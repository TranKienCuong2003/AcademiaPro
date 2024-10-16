<?php
session_start();
require_once __DIR__ . '/../../Database.php';

// Kết nối đến cơ sở dữ liệu
$database = Database::getInstance();
$conn = $database->getConnection();

// Lấy ID sinh viên từ tham số GET
$studentId = isset($_GET['student_id']) ? $_GET['student_id'] : null;

// Kiểm tra nếu ID sinh viên hợp lệ
if ($studentId) {
    // Truy vấn chi tiết điểm cho sinh viên
    $query = "
    SELECT 
        c.course_name AS course_name, 
        g.grade 
    FROM 
        grades g 
    JOIN 
        courses c ON g.course_id = c.id 
    WHERE 
        g.student_id = :student_id
    ";

    // Thực hiện truy vấn
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':student_id', $studentId);
    $stmt->execute();
    $grades = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Truy vấn tên sinh viên
    $stmtName = $conn->prepare("SELECT name FROM students WHERE id = :student_id");
    $stmtName->bindParam(':student_id', $studentId);
    $stmtName->execute();
    $studentName = $stmtName->fetchColumn();

} else {
    header("Location: index.php"); // Quay lại trang danh sách nếu không có ID
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách điểm sinh viên</title>
    <link rel="icon" type="image/png" href="/public/assets/imgages/Logo_AcademiaPro.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>
    <?php include '../partials/navbar.php'; ?> <!-- Navbar -->

    <div class="container mt-5">
        <h1 class="mb-4 text-center">Chi tiết điểm của <?php echo htmlspecialchars($studentName); ?></h1>
        
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Môn học</th>
                    <th>Điểm</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($grades): ?>
                    <?php foreach ($grades as $index => $grade): ?>
                        <tr style="background-color: <?php echo ($index % 2 == 0) ? '#ffffff' : '#d4edda'; ?>">
                            <td class="text-dark"><?php echo htmlspecialchars($grade['course_name']); ?></td>
                            <td class="text-center" 
                                style="font-weight: bold; color: <?php echo ($grade['grade'] < 5) ? 'red' : 'black'; ?>;">
                                <?php echo htmlspecialchars($grade['grade']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="text-center text-dark">Chưa có điểm cho sinh viên này.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="index.php" class="btn btn-primary">Quay lại</a>
    </div>

    <?php include '../partials/footer.php'; ?> <!-- Footer -->
</body>
</html>
