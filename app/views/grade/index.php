<?php
session_start();
require_once __DIR__ . '/../../Database.php';

// Kết nối đến cơ sở dữ liệu
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
    s.id, c.course_name
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

// Chuẩn bị dữ liệu cho biểu đồ
$chartData = [];
$courseNames = [];

// Tạo danh sách tên môn học
foreach ($grades as $grade) {
    if (!in_array($grade['course_name'], $courseNames)) {
        $courseNames[] = $grade['course_name'];
    }
}

// Tạo dữ liệu cho biểu đồ
foreach ($courseNames as $course_name) {
    $courseGrades = [];
    foreach ($studentGrades as $student) {
        $courseGrades[] = isset($student['grades'][$course_name]) ? $student['grades'][$course_name] : 0; // Nếu không có điểm, dùng 0
    }
    $chartData[$course_name] = $courseGrades;
}

// Tính tổng điểm và tỷ lệ phần trăm cho từng môn
$percentageData = [];
foreach ($chartData as $course_name => $grades) {
    $total = array_sum($grades);
    foreach ($grades as $grade) {
        if ($total > 0) {
            $percentageData[$course_name][] = round(($grade / $total) * 100, 2); // Tính tỷ lệ phần trăm
        } else {
            $percentageData[$course_name][] = 0;
        }
    }
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
    <style>
        th {
            background-color: #007bff;
            color: white;
        }
        
        td {
            vertical-align: middle;
            padding: 20px 10px;
        }

        .btn-action {
            width: 100px;
        }

        .chart-container {
            width: 100%;
            height: auto;
            margin: 0 auto;
        }

        .table-custom {
            background-color: #343a40;
            color: white;
        }

        .table-dark {
            border-color: rgba(0, 0, 0, 0.5);
        }

        .table-dark th, .table-dark td {
            border-color: rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>
    <?php include '../partials/navbar.php'; ?> <!-- Navbar -->
    
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Danh sách điểm sinh viên</h1>
        <table class="table table-dark table-bordered">
            <thead>
                <tr>
                    <th class="text-light" style="width: 10%;">Mã sinh viên</th>
                    <th class="text-light" style="width: 20%;">Tên sinh viên</th>
                    <?php foreach ($courseNames as $course_name): ?>
                        <th class="text-light" style="width: <?php echo 70 / count($courseNames); ?>%;">
                            <?php echo htmlspecialchars($course_name); ?>
                        </th>
                    <?php endforeach; ?>
                    <th class="text-light" style="width: 10%;">Hành động</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($studentGrades as $studentId => $student): ?>
                    <tr style="background-color: <?php echo (array_search($studentId, array_keys($studentGrades)) % 2 == 0) ? '#f8f9fa' : '#d1e7dd'; ?>">
                        <td class="text-dark text-center"><?php echo htmlspecialchars($studentId); ?></td>
                        <td class="text-dark" data-toggle="tooltip" title="<?php echo htmlspecialchars($student['student_name'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?php 
                            // Tách tên sinh viên và lấy hai từ cuối
                            $nameParts = explode(' ', trim($student['student_name']));
                            $displayName = count($nameParts) >= 2 ? $nameParts[count($nameParts) - 2] . ' ' . $nameParts[count($nameParts) - 1] : $student['student_name'];
                            echo htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8'); 
                            ?>
                        </td>
                        <?php foreach ($courseNames as $course_name): ?>
                            <?php 
                                $grade = isset($student['grades'][$course_name]) ? $student['grades'][$course_name] : null;
                                $gradeClass = ($grade !== null && $grade < 5) ? 'low-grade' : ''; // Thêm class nếu điểm < 5
                            ?>
                            <td class="text-dark text-center <?php echo $gradeClass; ?>">
                                <?php echo $grade !== null ? htmlspecialchars($grade) : 'Chưa có'; ?>
                            </td>
                        <?php endforeach; ?>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="edit.php?student_id=<?php echo $studentId; ?>" class="btn btn-warning btn-sm mx-1">Sửa</a>
                                <a href="student_detail.php?student_id=<?php echo $studentId; ?>" class="btn btn-info btn-sm mx-1">Xem</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php include '../partials/chat.php'; ?> <!-- Chat Bot -->

    <?php include '../partials/footer.php'; ?> <!-- Footer -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
