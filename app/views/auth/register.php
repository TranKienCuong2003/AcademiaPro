<?php
session_start(); // Bắt đầu phiên làm việc

// Kiểm tra nếu có thông báo lỗi hoặc thành công
$errorMessage = isset($_SESSION['error']) ? htmlspecialchars($_SESSION['error']) : '';
unset($_SESSION['error']);

$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="icon" type="image/png" href="/public/assets/imgages/Logo_AcademiaPro.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>
    <?php include '../partials/navbar.php'; ?> <!-- Navbar -->

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Đăng ký</h2>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-success" role="alert">
                        <?= $message; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($errorMessage)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $errorMessage; ?>
                    </div>
                <?php endif; ?>

                <form action="/app/controllers/AuthController.php?action=register" method="POST" onsubmit="return validateForm();">
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên đăng nhập</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        <div class="invalid-feedback" id="passwordError" style="display: none;">
                            Mật khẩu và xác nhận mật khẩu không khớp.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
                </form>
                
                <p class="text-center mt-3">
                    Đã có tài khoản? <a href="login.php">Đăng nhập</a>
                </p>
            </div>
        </div>
    </div>

    <?php include '../partials/footer.php'; ?> <!-- Footer -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                const errorDiv = document.getElementById('passwordError');
                errorDiv.style.display = 'block';
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
