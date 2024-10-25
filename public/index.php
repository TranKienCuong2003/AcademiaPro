<?php 
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>AcademiaPro - Hệ thống quản lý giáo dục</title>
    <link rel="icon" type="image/png" href="../public/assets/imgages/Logo_AcademiaPro.png">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>
    <?php include '../app/views/partials/navbar.php'; ?> <!-- Navbar -->

    <!-- Info Section (Giới thiệu ngắn) -->
    <section class="info-section">
        <div class="container">
            <h2>Hệ thống Quản lý Giáo dục AcademiaPro</h2>
            <p>Chào mừng đến với hệ thống quản lý giáo dục trực tuyến, giúp bạn quản lý thông tin về giảng viên, sinh viên và các môn học một cách đơn giản và hiệu quả.</p>
        </div>
    </section>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1 class="display-4">Chào mừng đến với Hệ thống AcademiaPro</h1>
            <p class="lead">Quản lý thông tin giảng viên, sinh viên và môn học dễ dàng và hiệu quả.</p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container mt-5">
        <div class="row">
            <!-- Card Giảng viên -->
            <div class="col-md-4">
                <div class="card card-custom shadow-sm">
                    <img src="../public/assets/imgages/Teacher.jpeg" class="card-img-top" alt="Giảng viên">
                    <div class="card-body text-center">
                        <h5 class="card-title">Quản lý Giảng viên</h5>
                        <p class="card-text">Quản lý danh sách giảng viên theo từng môn dạy</p>
                        <a href="/app/views/instructors/index.php" class="btn btn-custom">Xem chi tiết</a>
                    </div>
                </div>
            </div>

            <!-- Card Sinh viên -->
            <div class="col-md-4">
                <div class="card card-custom shadow-sm">
                    <img src="../public/assets/imgages/Studens.webp" class="card-img-top" alt="Sinh viên">
                    <div class="card-body text-center">
                        <h5 class="card-title">Quản lý Sinh viên</h5>
                        <p class="card-text">Quản lý danh sách sinh viên theo lớp học và môn học.</p>
                        <a href="/app/views/students/index.php" class="btn btn-custom">Xem chi tiết</a>
                    </div>
                </div>
            </div>

            <!-- Card Môn học -->
            <div class="col-md-4">
                <div class="card card-custom shadow-sm">
                    <img src="../public/assets/imgages/Subject.jpeg" class="card-img-top" alt="Môn học">
                    <div class="card-body text-center">
                        <h5 class="card-title">Quản lý Môn học</h5>
                        <p class="card-text">Quản lý các môn học và nội dung chương trình đào tạo.</p>
                        <a href="/app/views/courses/index.php" class="btn btn-custom">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include '../app/views/partials/chat.php'; ?> <!-- Chat Bot -->
    
    <?php include '../app/views/partials/footer.php'; ?> <!-- Footer -->

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
