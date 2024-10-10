<?php
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
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/3595/3595030.png">
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
        .edit-button {
            margin-top: 10px;
        }
        .chart-container {
            width: 100%;
            height: auto;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Danh sách điểm sinh viên</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mã sinh viên</th>
                    <th>Tên sinh viên</th>
                    <?php
                    // Lấy danh sách tên môn từ điểm của sinh viên
                    foreach ($courseNames as $course_name) {
                        echo "<th>" . htmlspecialchars($course_name) . "</th>";
                    }
                    ?>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($studentGrades as $studentId => $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($studentId); ?></td>
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
                            <a href="student_chart.php?student_id=<?php echo $studentId; ?>" class="btn btn-info btn-sm">Xem biểu đồ</a> <!-- Thêm nút này -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Thêm biểu đồ so sánh điểm -->
        <h2 class="mt-5">Biểu đồ so sánh điểm giữa các sinh viên</h2>
        <div class="chart-container">
            <canvas id="studentComparisonChart"></canvas>
        </div>
    </div>

    <?php include '../partials/footer.php'; ?> <!-- Include Footer -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Dữ liệu cho biểu đồ so sánh điểm
            var labels = <?php echo json_encode(array_keys($studentGrades)); ?>;
            var datasets = [];

            // Mảng màu sắc cho các môn
            var colors = [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ];

            // Tạo dataset cho từng môn
            <?php 
            $index = 0; // Khởi tạo index
            foreach ($percentageData as $course_name => $percentages): ?>
                datasets.push({
                    label: '<?php echo htmlspecialchars($course_name); ?>',
                    data: <?php echo json_encode($percentages); ?>,
                    backgroundColor: colors[<?php echo $index; ?> % colors.length],
                    borderColor: colors[<?php echo $index; ?> % colors.length].replace(/0.5/, '1'),
                    borderWidth: 1
                });
            <?php $index++; endforeach; ?>

            // Tạo biểu đồ
            var ctx = document.getElementById('studentComparisonChart').getContext('2d');
            var studentComparisonChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'So sánh điểm giữa các sinh viên theo môn học'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Điểm (%)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Mã sinh viên'
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
