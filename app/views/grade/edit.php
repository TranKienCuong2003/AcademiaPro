<?php
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
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Sửa điểm sinh viên: <?php echo htmlspecialchars($grades[0]['student_name']); ?></h1>
    <form action="update.php" method="post">
        <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($grades[0]['student_id']); ?>">
        
        <?php foreach ($grades as $grade): ?>
            <div class="form-group">
                <label for="course_<?php echo $grade['course_id']; ?>"><?php echo htmlspecialchars($grade['course_name']); ?></label>
                <input type="text" class="form-control" id="course_<?php echo $grade['course_id']; ?>" name="grades[<?php echo $grade['course_id']; ?>]" value="<?php echo htmlspecialchars($grade['grade']); ?>">
            </div>
        <?php endforeach; ?>
        
        <button type="submit" class="btn btn-primary">Cập nhật điểm</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
