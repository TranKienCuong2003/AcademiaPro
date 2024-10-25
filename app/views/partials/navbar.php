<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="/public/index.php">
            <img src="/public/assets/imgages/Logo_AcademiaPro.png" alt="Logo" style="height: 40px; width: auto;">
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Xin chào, <span class="navbar-text-user"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                            <!-- Thêm Thông tin tài khoản -->
                            <a class="dropdown-item" href="/app/views/auth/account.php">Thông tin tài khoản</a>
                            <!-- Gọi đến action logout trong AuthController -->
                            <a class="dropdown-item" href="/app/controllers/AuthController.php?action=logout">Đăng xuất</a>
                        </div>
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
