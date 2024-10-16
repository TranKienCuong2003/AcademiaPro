<?php
require_once __DIR__ . '/../models/Instructor.php';

class InstructorController {
    private $instructorModel;

    public function __construct($db) {
        // Truyền tham số $db vào constructor của Instructor
        $this->instructorModel = new Instructor($db);
    }

    // Hiển thị danh sách giảng viên
    public function index($searchTerm = '') {
        $instructors = $this->instructorModel->getInstructors($searchTerm);
        $view = __DIR__ . '/../views/instructor/index.php';
        require_once __DIR__ . '/../views/layout.php';
    }

    // Thêm giảng viên mới
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $subject_taught = $_POST['subject_taught'];
            $degree = $_POST['degree'];

            $this->instructorModel->createInstructor($name, $subject_taught, $degree);
            $this->redirect('index.php');
        }
        $view = __DIR__ . '/../views/instructor/create.php';
        require_once __DIR__ . '/../views/layout.php';
    }

    // Sửa giảng viên
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $subject_taught = $_POST['subject_taught'];
            $degree = $_POST['degree'];

            $this->instructorModel->updateInstructor($id, $name, $subject_taught, $degree);
            $this->redirect('index.php');
        }

        $instructor = $this->instructorModel->getInstructorById($id);
        $view = __DIR__ . '/../views/instructor/edit.php';
        require_once __DIR__ . '/../views/layout.php';
    }

    // Xóa giảng viên
    public function delete($id) {
        $this->instructorModel->deleteInstructor($id);
        $this->redirect('index.php');
    }

    // Điều hướng với JavaScript
    private function redirect($url) {
        echo "<script>window.location.href = '$url';</script>";
        exit();
    }
}
?>
