<?php
session_start();
require_once '../../../config.php';
require_once '../../models/Student.php';

if (!isset($_GET['id'])) {
    $_SESSION['error'] = 'Không tìm thấy sinh viên!';
    header('Location: index.php');
    exit();
}

$database = new Database();
$conn = $database->getConnection();
$student = new Student($conn);

// Lấy thông tin sinh viên theo ID
$id = (int)$_GET['id'];
$query = "SELECT * FROM students WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$studentData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$studentData) {
    $_SESSION['error'] = 'Sinh viên không tồn tại!';
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin Sinh viên: <?php echo htmlspecialchars($studentData['name']); ?></title>
    <link rel="icon" type="image/png" href="/public/assets/imgages/Logo_AcademiaPro.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
    <style>
        .card-img {
            border: 2px solid #007bff;
            border-radius: 0.25rem;
            width: 100%;
            height: auto;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <?php include '../partials/navbar.php'; ?> <!-- Navbar -->

    <div class="container mt-5">
        <h1 class="mb-4">Thông tin chi tiết Sinh viên</h1>
        <div class="card">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img 
                        src="<?php echo htmlspecialchars($studentData['avatar']); ?>" 
                        class="card-img" 
                        alt="Avatar Sinh viên"
                    >
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo htmlspecialchars($studentData['name']); ?>
                        </h5>
                        <p class="card-text">
                            <strong>Lớp:</strong> 
                            <?php echo htmlspecialchars($studentData['class']); ?>
                        </p>
                        <p class="card-text">
                            <strong>Chuyên ngành:</strong> 
                            <?php echo htmlspecialchars($studentData['major']); ?>
                        </p>
                        <p class="card-text">
                            <strong>Ngày sinh:</strong> 
                            <?php 
                                $dateOfBirth = new DateTime($studentData['dob']);
                                echo $dateOfBirth->format('d/m/Y'); 
                            ?>
                        </p>
                        <p class="card-text">
                            <strong>Quê quán:</strong> 
                            <?php echo htmlspecialchars($studentData['birthplace']); ?>
                        </p>
                        <p class="card-text">
                            <strong>Số điện thoại:</strong> 
                            <a href="tel:<?php echo htmlspecialchars($studentData['phone']); ?>">
                                <?php echo htmlspecialchars($studentData['phone']); ?>
                            </a>
                        </p>
                        <p class="card-text">
                            <strong>Email:</strong> 
                            <a href="mailto:<?php echo htmlspecialchars($studentData['email']); ?>">
                                <?php echo htmlspecialchars($studentData['email']); ?>
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
