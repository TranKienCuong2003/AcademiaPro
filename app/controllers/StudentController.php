<?php
require_once '../app/config.php';
require_once '../app/models/Student.php';

class StudentController {
    private $student;

    public function index() {
        // Lấy danh sách sinh viên
        $students = $this->student->getStudents();

        // Kiểm tra kết quả
        if ($students === false) {
            $students = [];
            $error = "Có lỗi xảy ra khi lấy danh sách sinh viên.";
        } elseif (empty($students)) {
            $students = []; // Không có sinh viên nào
        }

        // Gọi view và truyền biến $students và $error
        require '../app/views/students/index.php';
    }    

    public function create() {
        $error = ""; // Khởi tạo biến lỗi
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = htmlspecialchars(trim($_POST['name']));

            if ($this->student->createStudent($name)) {
                header('Location: /public/index.php?action=index');
                exit();
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
                    header('Location: /public/index.php?action=index');
                    exit();
                } else {
                    $error = "Có lỗi xảy ra khi cập nhật sinh viên.";
                }
            }
        }

        // Gọi view và truyền biến $student và $error
        require '../app/views/students/edit.php';
    }

    public function delete($id) {
        $error = ""; // Khởi tạo biến lỗi
        if ($this->student->deleteStudent($id)) {
            header('Location: /public/index.php?action=index');
            exit();
        } else {
            $error = "Có lỗi xảy ra khi xóa sinh viên.";
        }

        // Thông báo lỗi sau khi xóa (nếu có)
        require '../app/views/students/index.php';
    }
}
?>
