<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/3595/3595030.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
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
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Đăng nhập</h2>

                <?php
                session_start();
                // Kiểm tra nếu có thông báo lỗi
                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger" role="alert">
                            ' . $_SESSION['error'] . '
                          </div>';
                    // Xóa thông báo lỗi sau khi hiển thị
                    unset($_SESSION['error']);
                }
                ?>

                <form action="/app/controllers/LoginController.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên đăng nhập</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                </form>
                <p class="text-center mt-3">Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
