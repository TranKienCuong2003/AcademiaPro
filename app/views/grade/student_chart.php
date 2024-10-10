<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sơ đồ điểm sinh viên</title>
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/3595/3595030.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Biểu đồ điểm sinh viên</h1>
    <canvas id="studentChart" width="360" height="160"></canvas>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var studentId = <?php echo isset($_GET['student_id']) ? (int)$_GET['student_id'] : 0; ?>;

            fetch(`student_scores.php?student_id=${studentId}`)
                .then(response => response.json()) // Chuyển đổi thành JSON
                .then(data => {
                    console.log("Parsed JSON:", data);

                    if (data.courses.length > 0 && data.grades.length > 0) {
                        var ctx = document.getElementById('studentChart').getContext('2d');
                        var studentChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.courses,
                                datasets: [{
                                    label: `Điểm của ${data.student_name}`,
                                    data: data.grades,
                                    backgroundColor: 'rgba(75, 180, 180, 0.5)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    } else {
                        alert("Không có dữ liệu cho sinh viên này.");
                    }
                })
                .catch(error => {
                    console.error("Lỗi khi phân tích cú pháp JSON:", error);
                });
        });
    </script>
</body>
</html>
