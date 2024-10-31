<?php
require_once '../config/config.php';
require_once '../models/Grade.php';

class GradeController {
    private $db;
    private $grade;

    public function __construct() {
        // Khởi tạo kết nối cơ sở dữ liệu và mô hình Grade
        $this->db = new Database();
        $this->grade = new Grade($this->db->getConnection());
    }

    public function index() {
        // Lấy danh sách điểm
        $grades = $this->grade->getAllGrades();
        include '../app/views/grade/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy thông tin từ form tạo điểm
            $student_id = intval($_POST['student_id']);
            $course_id = intval($_POST['course_id']);
            $score = floatval($_POST['score']);

            // Tạo điểm mới
            if ($this->grade->createGrade($student_id, $course_id, $score)) {
                $this->redirect('/public/index.php?controller=GradeController&action=index');
            } else {
                echo "Có lỗi xảy ra khi tạo điểm.";
            }
        }

        // Hiển thị form tạo điểm
        include '../app/views/grade/create.php';
    }

    public function edit($id) {
        // Lấy thông tin điểm theo ID để chỉnh sửa
        $grade = $this->grade->getGradeById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy thông tin đã chỉnh sửa từ form
            $student_id = intval($_POST['student_id']);
            $course_id = intval($_POST['course_id']);
            $score = floatval($_POST['score']);

            // Cập nhật thông tin điểm
            if ($this->grade->updateGrade($id, $student_id, $course_id, $score)) {
                $this->redirect('/public/index.php?controller=GradeController&action=index');
            } else {
                echo "Có lỗi xảy ra khi cập nhật điểm.";
            }
        }

        // Hiển thị form chỉnh sửa điểm
        include '../app/views/grade/edit.php';
    }

    public function delete($id) {
        // Xóa điểm theo ID
        if ($this->grade->deleteGrade($id)) {
            $this->redirect('/public/index.php?controller=GradeController&action=index');
        } else {
            echo "Có lỗi xảy ra khi xóa điểm.";
        }
    }

    // Helper function để điều hướng bằng JavaScript
    private function redirect($url) {
        echo "<script>window.location.href = '$url';</script>";
        exit();
    }
}
?>
