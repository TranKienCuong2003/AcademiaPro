<?php
require_once __DIR__ . '/../../Database.php';

// Lấy kết nối từ Database
$database = Database::getInstance();
$conn = $database->getConnection();

// Truy vấn dữ liệu
$query = "
SELECT 
    s.id AS student_id, 
    s.name AS student_name, 
    c.course_name AS course_name, 
    g.grade
FROM 
    students s
JOIN 
    grades g ON s.id = g.student_id
JOIN 
    courses c ON g.course_id = c.id
ORDER BY 
    s.name, c.course_name
";

// Thực hiện truy vấn
$stmt = $conn->prepare($query);
$stmt->execute();
$grades = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Khởi tạo mảng để lưu điểm
$studentGrades = [];

// Nhóm điểm theo sinh viên
foreach ($grades as $grade) {
    $studentId = $grade['student_id'];
    
    if (!isset($studentGrades[$studentId])) {
        $studentGrades[$studentId] = [
            'student_name' => $grade['student_name'],
            'grades' => []
        ];
    }
    
    $studentGrades[$studentId]['grades'][$grade['course_name']] = $grade['grade'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách điểm sinh viên</title>
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/3595/3595030.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th {
            background-color: #007bff;
            color: white;
        }
        td {
            vertical-align: middle;
            padding: 20px 10px;
        }
        .edit-button {
            margin-top: 10px;
        }
    </style>
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
        <h1 class="mb-4">Danh sách điểm sinh viên</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mã sinh viên</th> <!-- Thêm cột mã sinh viên -->
                    <th>Tên sinh viên</th>
                    <?php
                    // Lấy danh sách tên môn từ điểm của sinh viên
                    $courseNames = [];
                    foreach ($grades as $grade) {
                        if (!in_array($grade['course_name'], $courseNames)) {
                            $courseNames[] = $grade['course_name'];
                            echo "<th>" . htmlspecialchars($grade['course_name']) . "</th>";
                        }
                    }
                    ?>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($studentGrades as $studentId => $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($studentId); ?></td> <!-- Hiển thị mã sinh viên -->
                        <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                        <?php
                        // Hiển thị điểm cho từng môn
                        foreach ($courseNames as $course_name) {
                            if (isset($student['grades'][$course_name])) {
                                echo "<td>" . htmlspecialchars($student['grades'][$course_name]) . "</td>";
                            } else {
                                echo "<td>Chưa có</td>";
                            }
                        }
                        ?>
                        <!-- Nút sửa điểm cho toàn bộ môn của sinh viên -->
                        <td>
                            <a href="edit.php?student_id=<?php echo $studentId; ?>" class="btn btn-warning btn-sm edit-button">Sửa điểm</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
