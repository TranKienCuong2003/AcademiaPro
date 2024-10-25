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
    <style>
        body {
            background-image: url('/public/assets/imgages/Backroung_Auth.jpg');
            background-size: cover;
            background-position: center;
            color: #000;
        }
        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .alert-important {
            color: #dc3545;
            font-weight: bold;
        }
        .btn-disabled {
            background-color: #ccc;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="card p-4">
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

                <form id="registerForm" action="/app/controllers/AuthController.php?action=register" method="POST" onsubmit="return validateForm();">
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên đăng nhập</label>
                        <input type="text" class="form-control" id="username" name="username" required oninput="toggleSubmitButton();">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required oninput="toggleSubmitButton();">
                    </div>
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Họ tên</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" required oninput="toggleSubmitButton();">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone" required oninput="toggleSubmitButton();">
                    </div>
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Link ảnh đại diện</label>
                        <input type="text" class="form-control" id="avatar" name="avatar" oninput="toggleSubmitButton();">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required oninput="toggleSubmitButton();">
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required oninput="toggleSubmitButton();">
                        <div class="invalid-feedback" id="passwordError" style="display: none;">
                            Mật khẩu và xác nhận mật khẩu không khớp.
                        </div>
                    </div>

                    <button type="submit" id="submitButton" class="btn btn-primary w-100 mt-3 btn-disabled" disabled>Đăng ký</button>
                </form>

                <p class="text-center mt-3">
                    Đã có tài khoản? <a href="login.php">Đăng nhập</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Modal cảnh báo -->
    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertModalLabel">Cảnh báo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="alertModalBody">
                    <!-- Nội dung cảnh báo sẽ được thêm ở đây -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSubmitButton() {
            const username = document.getElementById('username').value.trim();
            const email = document.getElementById('email').value.trim();
            const fullname = document.getElementById('fullname').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const password = document.getElementById('password').value.trim();
            const confirmPassword = document.getElementById('confirm_password').value.trim();
            const submitButton = document.getElementById('submitButton');

            // Kiểm tra xem tất cả các trường có được điền không
            if (username && email && fullname && phone && password && confirmPassword) {
                submitButton.classList.remove('btn-disabled');
                submitButton.disabled = false;
            } else {
                submitButton.classList.add('btn-disabled');
                submitButton.disabled = true;
            }
        }

        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const avatar = document.getElementById('avatar').value;

            // Kiểm tra mật khẩu
            if (password !== confirmPassword) {
                const errorDiv = document.getElementById('passwordError');
                errorDiv.style.display = 'block';
                return false;
            } else {
                document.getElementById('passwordError').style.display = 'none'; // Ẩn thông báo lỗi khi mật khẩu khớp
            }

            // Kiểm tra định dạng đường link ảnh
            const validImageExtensions = ['.png', '.jpg', '.jpeg', '.gif'];
            const isImageLink = validImageExtensions.some(ext => avatar.endsWith(ext));

            if (!avatar) {
                return true; // Chấp nhận trường trống
            } else if (!isImageLink) {
                const alertModalBody = document.getElementById('alertModalBody');
                alertModalBody.textContent = 'Link mà bạn lấy không phải là ảnh PNG (.png), JPEG (.jpeg), GIF(.gif).';
                const alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
                alertModal.show();
                return false;
            }

            return true; // Mọi thứ đều hợp lệ
        }

        // Ngăn không cho nhấn nút nếu chưa điền đầy đủ thông tin
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            if (document.getElementById('submitButton').disabled) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
