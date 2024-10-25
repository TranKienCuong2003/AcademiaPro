<?php
session_start();

require_once __DIR__ . '/../../Database.php';

// Lấy kết nối từ Database
$database = Database::getInstance();
$conn = $database->getConnection();

// Kiểm tra nếu có truyền id trong URL
if (isset($_GET['student_id'])) {
    $studentId = $_GET['student_id'];

    // Truy vấn thông tin điểm của sinh viên dựa trên ID
    $query = "
    SELECT 
        s.id AS student_id, 
        s.name AS student_name, 
        c.id AS course_id, 
        c.course_name, 
        g.grade
    FROM 
        grades g
    JOIN 
        students s ON g.student_id = s.id
    JOIN 
        courses c ON g.course_id = c.id
    WHERE 
        s.id = :student_id
    ";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':student_id', $studentId);
    $stmt->execute();
    $grades = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Kiểm tra xem sinh viên có điểm không
    if (empty($grades)) {
        echo "Không tìm thấy thông tin điểm cho sinh viên này.";
        exit;
    }
} else {
    // Hiển thị thông báo lỗi nếu không có ID
    echo '<div style="color: red; font-weight: bold; text-align: center; margin-top: 20px;">';
    echo "ID sinh viên không được cung cấp.";
    echo '</div>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa điểm sinh viên</title>
    <link rel="icon" type="image/png" href="/public/assets/imgages/Logo_AcademiaPro.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
    <script>
        function validateGrades() {
            const inputs = document.querySelectorAll('input[type="number"]');
            for (let input of inputs) {
                let value = parseFloat(input.value);
                // Kiểm tra nếu giá trị không hợp lệ
                if (isNaN(value) || value < 0 || value > 10) {
                    alert("Điểm phải nằm trong khoảng từ 0.00 đến 10.00.");
                    input.focus();
                    return false;
                }
                // Đặt điểm tối thiểu là 0.00
                if (value === 0) {
                    input.value = "0.00";
                } else {
                    // Chuyển đổi giá trị thành chuỗi và loại bỏ số 0 ở cuối
                    input.value = value.toString().replace(/\.0+$/, '').replace(/(\.[0-9]*[1-9])0+$/, '$1');
                }
            }
            return true;
        }
    </script>
</head>
<body>
    <?php include '../partials/navbar.php'; ?> <!-- Navbar -->
    <div class="container mt-5">
        <h1 class="mb-4">Sửa điểm sinh viên: <?php echo htmlspecialchars($grades[0]['student_name']); ?></h1>
        <form action="update.php" method="post" onsubmit="return validateGrades();">
            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($grades[0]['student_id']); ?>">
            
            <?php foreach ($grades as $grade): ?>
                <div class="form-group">
                    <label for="course_<?php echo $grade['course_id']; ?>"><?php echo htmlspecialchars($grade['course_name']); ?></label>
                    <input type="number" class="form-control" id="course_<?php echo $grade['course_id']; ?>" name="grades[<?php echo $grade['course_id']; ?>]" 
                        value="<?php echo htmlspecialchars($grade['grade']); ?>" step="0.01" min="0" max="10" required>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary">Cập nhật điểm</button>
        </form>
    </div>

    <?php include '../partials/chat.php'; ?> <!-- Chat Bot -->

    <?php include '../partials/footer.php'; ?> <!-- Footer -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
