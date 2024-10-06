<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/3595/3595030.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Đăng ký</h2>
                <form action="/app/controllers/RegisterController.php" method="POST" onsubmit="return validateForm();">
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
                <p class="text-center mt-3">Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const passwordError = document.getElementById('passwordError');

            // Kiểm tra xem mật khẩu và xác nhận mật khẩu có giống nhau không
            if (password !== confirmPassword) {
                passwordError.style.display = 'block';
                return false; // Ngăn không cho form được gửi
            }

            passwordError.style.display = 'none';
            return true; // Cho phép form được gửi
        }
    </script>
</body>
</html>
