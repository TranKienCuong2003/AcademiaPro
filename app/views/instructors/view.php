<?php
session_start();
require_once '../../config/config.php';
require_once '../../models/Instructor.php';

if (!isset($_GET['id'])) {
    $_SESSION['error'] = 'Không tìm thấy giảng viên!';
    header('Location: index.php');
    exit();
}

$database = new Database();
$conn = $database->getConnection();
$instructor = new Instructor($conn); // Khởi tạo đối tượng Instructor

// Lấy thông tin giảng viên theo ID
$id = (int)$_GET['id'];
$query = "SELECT * FROM instructors WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$instructorData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$instructorData) {
    $_SESSION['error'] = 'Giảng viên không tồn tại!';
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin giảng viên: <?php echo htmlspecialchars($instructorData['name']); ?></title>
    <link rel="icon" type="image/png" href="/public/assets/imgages/Logo_AcademiaPro.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>
    <?php include '../partials/navbar.php'; ?> <!-- Navbar -->

    <div class="container mt-5">
        <h1 class="mb-4">Thông tin chi tiết Giảng viên: <?php echo htmlspecialchars($instructorData['name']); ?></h1>
        <div class="card">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img 
                        src="<?php echo htmlspecialchars($instructorData['avatar']); ?>" 
                        class="card-img" 
                        alt="Avatar Giảng viên" 
                        style="object-fit: cover; height: 100%;"
                    >
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo htmlspecialchars($instructorData['name']); ?>
                        </h5>
                        <p class="card-text">
                            <strong>Môn học giảng dạy:</strong> 
                            <?php echo htmlspecialchars($instructorData['subject_taught']); ?>
                        </p>
                        <p class="card-text">
                            <strong>Bằng cấp:</strong> 
                            <?php echo htmlspecialchars($instructorData['degree']); ?>
                        </p>
                        <p class="card-text">
                            <strong>Ngày sinh:</strong> 
                            <?php 
                                $dateOfBirth = new DateTime($instructorData['date_of_birth']);
                                echo $dateOfBirth->format('d/m/Y'); 
                            ?>
                        </p>
                        <p class="card-text">
                            <strong>Quê quán:</strong> 
                            <?php echo htmlspecialchars($instructorData['hometown']); ?>
                        </p>
                        <p class="card-text">
                            <strong>Địa chỉ hiện tại:</strong> 
                            <?php echo htmlspecialchars($instructorData['current_address']); ?>
                        </p>
                        <p class="card-text">
                            <strong>Số điện thoại:</strong> 
                            <a href="tel:<?php echo htmlspecialchars($instructorData['phone']); ?>">
                                <?php echo htmlspecialchars($instructorData['phone']); ?>
                            </a>
                        </p>
                        <p class="card-text">
                            <strong>Email:</strong> 
                            <a href="mailto:<?php echo htmlspecialchars($instructorData['email']); ?>">
                                <?php echo htmlspecialchars($instructorData['email']); ?>
                            </a>
                        </p>
                        <a href="index.php" class="btn btn-secondary mt-3">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../partials/chat.php'; ?> <!-- Chat Bot -->

    <?php include '../partials/footer.php'; ?> <!-- Footer -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
