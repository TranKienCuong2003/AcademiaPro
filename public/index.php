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
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/3595/3595030.png">
    <style>
        body {
            background-color: #e9f7ef;
        }

        .hero {
            background-image: url('https://source.unsplash.com/1600x900/?education');
            background-size: cover;
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .card-img-top {
            height: 200px;
            object-fit: contain;
        }

        /* Button Custom */
        .btn-custom {
            background-color: #e27f28;
            color: white;
        }

        .btn-custom:hover {
            background-color: #de7921;
            color: white;
        }

        .card-custom {
            transition: box-shadow 0.3s;
        }

        .card-custom:hover {
            box-shadow: 1px 4px 20px rgba(0, 0, 0, 0.5);
            background-color: #f0f0f0;
        }

        .info-section {
            padding: 40px 0;
            background-color: #f0f9ff;
            text-align: center;
        }

        .info-section h2 {
            color: #007bff;
        }

        .info-section p {
            font-size: 18px;
            color: #333;
        }

        /* Navbar */
        .navbar-light {
            background-color: #4c61d6;
        }

        .navbar-light .navbar-brand,
        .navbar-light .nav-link {
            color: #fff !important;
            transition: color 0.3s;
        }

        .navbar-light .nav-link:hover,
        .navbar-light .navbar-brand:hover {
            color: #ff9800 !important;
        }

        .navbar-light .navbar-toggler-icon {
            filter: brightness(0) invert(1);
        }

        .navbar-text {
            margin-left: 70px;
            color: #fff !important;
        }

        .navbar-text-user {
            color: #ff9800 !important;
            font-weight: 800;
        }

        .nav-item-exit {
            margin-left: 10px;
        }

        .list-unstyled li a {
            color: #fff;
            text-decoration: none;
        }

        /* Footer */
        footer {
            background-color: #4c61d6;
            color: white;
        }

        .footer-description {
            cursor: default;
        }

        .footer-description a {
            cursor: pointer;
        }
</style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/public/index.php">
                <img src="https://cdn-icons-png.flaticon.com/512/3595/3595030.png" alt="Logo" style="height: 40px; width: auto;">
                AcademiaPro
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/app/views/instructors/index.php">Quản lý Giảng viên</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/app/views/students/index.php">Quản lý Sinh viên</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/app/views/courses/index.php">Quản lý Môn học</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/app/views/grade/index.php">Quản lý Điểm thi</a>
                    </li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item">
                            <span class="navbar-text">Xin chào, 
                                <span class="navbar-text-user">
                                    <?php echo htmlspecialchars($_SESSION['username']); ?>
                                </span>
                            </span>    
                        </li>

                        <li class="nav-item nav-item-exit">
                            <a class="nav-link" href="/app/views/auth/logout.php">Đăng xuất</a>
                        </li>

                    <?php else: ?>

                        <li class="nav-item">
                            <a class="nav-link" href="/app/views/auth/login.php">Đăng nhập</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/app/views/auth/register.php">Đăng ký</a>
                        </li>

                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Info Section (Giới thiệu ngắn) -->
    <div class="info-section">
        <div class="container">
            <h2>
                Hệ thống Quản lý Giáo dục
            </h2>

            <p>
                Chào mừng đến với hệ thống quản lý giáo dục trực tuyến, giúp bạn quản lý thông tin về giảng viên, sinh viên và các môn học một cách đơn giản và hiệu quả.
            </p>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="hero">
        <div class="container">
            <h1 class="display-4">
                Chào mừng đến với Hệ thống AcademiaPro
            </h1>

            <p class="lead">
                Quản lý thông tin giảng viên, sinh viên và môn học dễ dàng và hiệu quả.
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row">
            <!-- Card Giảng viên -->
            <div class="col-md-4">
                <div class="card card-custom shadow-sm">
                    <img src="https://png.pngtree.com/thumb_back/fw800/background/20240527/pngtree-a-teacher-explains-to-students-on-the-blackboard-image_15824539.jpg" class="card-img-top" alt="Giảng viên">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            Quản lý Giảng viên
                        </h5>

                        <p class="card-text">
                            Xem, thêm, sửa và xóa thông tin giảng viên.
                        </p>

                        <a href="/app/views/instructors/index.php" class="btn btn-custom">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Sinh viên -->
            <div class="col-md-4">
                <div class="card card-custom shadow-sm">
                    <img src="https://png.pngtree.com/png-vector/20190121/ourmid/pngtree-cute-style-cartoon-shape-college-students-graduation-photo-png-image_509093.jpg" class="card-img-top" alt="Sinh viên">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            Quản lý Sinh viên
                        </h5>

                        <p class="card-text">
                            Quản lý danh sách sinh viên theo lớp học và môn học.
                        </p>

                        <a href="/app/views/students/index.php" class="btn btn-custom">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Môn học -->
            <div class="col-md-4">
                <div class="card card-custom shadow-sm">
                    <img src="https://png.pngtree.com/png-vector/20230510/ourmid/pngtree-free-vector-book-lover-composition-with-stack-of-colorful-books-pencil-png-image_7093248.png" class="card-img-top" alt="Môn học">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            Quản lý Môn học
                        </h5>

                        <p class="card-text">
                            Quản lý các môn học và nội dung chương trình đào tạo.
                        </p>

                        <a href="/app/views/courses/index.php" class="btn btn-custom">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-lg-start mt-5">
    <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">
                        AcademiaPro
                    </h5>

                    <p class="footer-description">
                        Hệ thống quản lý giáo dục trực tuyến giúp bạn quản lý thông tin một cách dễ dàng và hiệu quả.
                    </p>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">
                        Liên kết nhanh
                    </h5>

                    <ul class="list-unstyled">
                        <li>
                            <a href="/app/views/instructors/index.php">
                                Giảng viên
                            </a>
                        </li>

                        <li>
                            <a href="/app/views/students/index.php">
                                Sinh viên
                            </a>
                        </li>

                        <li>
                            <a href="/app/views/courses/index.php">
                                Môn học
                            </a>
                        </li>

                        <li>
                            <a href="/app/views/grade/index.php">
                                Điểm thi
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Thông tin liên hệ</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope"></i> academiapro.edu.vn</li>
                        <li><i class="fas fa-phone"></i> (+84) 123456789123</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center p-3" style="background-color: #4157d6;">
            <p class="mb-0">© 2024 AcademiaPro. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
