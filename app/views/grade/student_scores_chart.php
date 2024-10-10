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

// Lấy danh sách tên môn từ điểm của sinh viên
foreach ($grades as $grade) {
    if (!in_array($grade['course_name'], $courseNames)) {
        $courseNames[] = $grade['course_name'];
    }
}

// Tạo dữ liệu biểu đồ cho từng môn
foreach ($courseNames as $course_name) {
    $courseGrades = [];
    foreach ($studentGrades as $student) {
        $courseGrades[] = isset($student['grades'][$course_name]) ? $student['grades'][$course_name] : 0; // Nếu không có điểm, dùng 0
    }
    $chartData[$course_name] = $courseGrades;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biểu Đồ Điểm Sinh Viên</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* CSS tùy chỉnh cho biểu đồ */
        canvas {
            max-width: 800px;
            margin: 20px auto;
        }
    </style>
</head>
<body>
    <h1>Biểu Đồ Điểm Sinh Viên</h1>
    <canvas id="studentChart"></canvas>

    <script>
        const chartData = <?php echo json_encode($chartData); ?>;
        const courseNames = <?php echo json_encode($courseNames); ?>;

        const ctx = document.getElementById('studentChart').getContext('2d');
        const studentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($studentGrades)); ?>, // Tên sinh viên
                datasets: courseNames.map((course, index) => ({
                    label: course,
                    data: chartData[course],
                    backgroundColor: `rgba(${75 + index * 20}, 192, 192, 0.5)`,
                    borderColor: `rgba(${75 + index * 20}, 192, 192, 1)`,
                    borderWidth: 1
                }))
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Điểm'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Sinh Viên'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
