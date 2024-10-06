<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Điểm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Thêm Điểm Mới</h1>
    <form method="POST">
        <div class="form-group">
            <label for="student_id">Student ID</label>
            <input type="text" class="form-control" id="student_id" name="student_id" required>
        </div>
        <div class="form-group">
            <label for="course_id">Course ID</label>
            <input type="text" class="form-control" id="course_id" name="course_id" required>
        </div>
        <div class="form-group">
            <label for="grade">Grade</label>
            <input type="number" class="form-control" id="grade" name="grade" required>
        </div>
        <div class="form-group">
            <label for="semester">Semester</label>
            <input type="text" class="form-control" id="semester" name="semester" required>
        </div>
        <div class="form-group">
            <label for="exam_date">Exam Date</label>
            <input type="date" class="form-control" id="exam_date" name="exam_date" required>
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="index.php" class="btn btn-secondary">Trở về</a>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
