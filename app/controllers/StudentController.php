<?php
require_once '../config/config.php';
require_once '../models/Student.php';

class StudentController {
    private $db;
    private $student;

    public function __construct() {
        // Khởi tạo kết nối cơ sở dữ liệu và mô hình Student
        $this->db = new Database();
        $this->student = new Student($this->db->getConnection());
    }

    public function index() {
        // Lấy danh sách sinh viên
        $students = $this->student->getStudents();

        // Kiểm tra kết quả
        if ($students === false) {
            $students = [];
            $error = "Có lỗi xảy ra khi lấy danh sách sinh viên.";
        } elseif (empty($students)) {
            $students = [];
        }

        // Gọi view và truyền biến $students và $error
        require '../app/views/students/index.php';
    }    

    public function create() {
        $error = ""; // Khởi tạo biến lỗi
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = htmlspecialchars(trim($_POST['name']));

            if ($this->student->createStudent($name)) {
                // Điều hướng bằng JavaScript
                $this->redirect('/public/index.php?controller=StudentController&action=index');
            } else {
                $error = "Có lỗi xảy ra khi tạo sinh viên.";
            }
        }

        // Gọi view và truyền biến $error
        require '../app/views/students/create.php';
    }

    public function edit($id) {
        $error = ""; // Khởi tạo biến lỗi
        $student = $this->student->getStudentById($id);
        
        // Kiểm tra xem sinh viên có tồn tại không
        if ($student === null) {
            $error = "Sinh viên không tồn tại.";
        } else {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = htmlspecialchars(trim($_POST['name']));

                if ($this->student->updateStudent($id, $name)) {
                    // Điều hướng bằng JavaScript
                    $this->redirect('/public/index.php?controller=StudentController&action=index');
                } else {
                    $error = "Có lỗi xảy ra khi cập nhật sinh viên.";
                }
            }
        }

        // Gọi view và truyền biến $student và $error
        require '../app/views/students/edit.php';
    }

    public function delete($id) {
        $error = "";
        if ($this->student->deleteStudent($id)) {
            // Điều hướng bằng JavaScript
            $this->redirect('/public/index.php?controller=StudentController&action=index');
        } else {
            $error = "Có lỗi xảy ra khi xóa sinh viên.";
        }

        // Gọi lại view để hiển thị danh sách sinh viên
        $students = $this->student->getStudents();
        require '../app/views/students/index.php';
    }

    // Helper function để điều hướng bằng JavaScript
    private function redirect($url) {
        echo "<script>window.location.href = '$url';</script>";
        exit();
    }
}
?>
