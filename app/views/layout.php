<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Quản Lý Sinh Viên</title>
</head>
<body>
    <div class="container">
        <?php 
        if (isset($view) && !empty($view)) {
            require_once $view;
        } else {
            echo '<div class="alert alert-danger">Không tìm thấy nội dung!</div>';
        }
        ?>
    </div>

    <footer class="mt-5">
        <div class="text-center">
            <p>© 2024 Quản lý sinh viên. Tất cả các quyền được bảo lưu.</p>
        </div>
    </footer>
</body>
</html>

