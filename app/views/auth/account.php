<?php
session_start();

// Sử dụng Composer autoload
require_once __DIR__ . '/../../../vendor/autoload.php';

// Tải các biến môi trường từ tệp .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['username'])) {
    header('Location: /app/views/auth/login.php');
    exit();
}

require_once __DIR__ . '/../../Database.php';

// Kết nối đến cơ sở dữ liệu sử dụng lớp Database
$db = Database::getInstance();
$conn = $db->getConnection();

// Truy vấn để lấy thông tin người dùng:
$user = [];
$stmt = $conn->prepare("SELECT username, email, fullname, phone, avatar FROM users WHERE username = ?");
$stmt->bindParam(1, $_SESSION['username']);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($result) > 0) {
    // Lấy thông tin người dùng
    $user = $result[0];
} else {
    // Nếu không tìm thấy người dùng, gán giá trị mặc định
    $user = [
        'username' => $_SESSION['username'],
        'email' => 'Chưa cập nhật',
        'fullname' => 'Chưa cập nhật',
        'phone' => 'Chưa cập nhật',
        'avatar' => '/public/assets/images/default-avatar.png'
    ];
}

// Đóng kết nối
$db->closeConnection();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin tài khoản</title>
    <link rel="icon" type="image/png" href="/public/assets/imgages/Logo_AcademiaPro.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/assets/css/style.css">
    <style>
        body {
            background-image: url('/public/assets/imgages/Backroung_Auth.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
        }
        .card {
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 15px; 
        }
        .card-header {
            border-bottom: none;
        }
        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #dc3545;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>
    <?php include '../partials/navbar.php'; ?>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card" style="max-width: 500px;">
            <div class="card-header text-center">
                <h2>Thông tin tài khoản</h2>
            </div>
            <div class="card-body text-center">
                <img src="<?php echo htmlspecialchars($user['avatar']); ?>" alt="Avatar" class="avatar mb-3">
                <p><strong>Tên tài khoản:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>Họ và tên:</strong> <?php echo htmlspecialchars($user['fullname']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            </div>
            <div class="card-footer text-center">
                <a href="/app/controllers/AuthController.php?action=logout" class="btn btn-danger">Đăng xuất</a>
                <a href="/public/index.php" class="btn btn-primary">Về trang chủ</a>
            </div>
        </div>
    </div>

    <?php include '../partials/chat.php'; ?> <!-- Chat Bot -->
    <?php include '../partials/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
