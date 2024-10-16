<?php
require_once '../app/config.php';
require_once '../app/models/Course.php';

class CourseController {
    private $db;
    private $course;

    public function __construct() {
        // Khởi tạo kết nối cơ sở dữ liệu và mô hình Course
        $this->db = new Database();
        $this->course = new Course($this->db->getConnection());
    }

    public function index() {
        // Xử lý tìm kiếm, lấy từ khóa tìm kiếm nếu có
        $searchTerm = isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '';

        // Lấy danh sách khóa học với điều kiện tìm kiếm
        $courses = $this->course->getCourses($searchTerm);
        include '../app/views/courses/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy thông tin từ form tạo khóa học
            $course_name = htmlspecialchars($_POST['course_name']);
            $credits = intval($_POST['credits']);

            // Tạo khóa học mới
            if ($this->course->createCourse($course_name, $credits)) {
                // Điều hướng bằng JavaScript
                $this->redirect('/public/index.php?controller=CourseController&action=index');
            } else {
                echo "Có lỗi xảy ra khi tạo khóa học.";
            }
        }

        // Hiển thị form tạo khóa học
        include '../app/views/courses/create.php';
    }

    public function edit($id) {
        // Lấy thông tin khóa học theo ID để chỉnh sửa
        $course = $this->course->getCourseById($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy thông tin đã chỉnh sửa từ form
            $course_name = htmlspecialchars($_POST['course_name']);
            $credits = intval($_POST['credits']);

            // Cập nhật thông tin khóa học
            if ($this->course->updateCourse($id, $course_name, $credits)) {
                // Điều hướng bằng JavaScript
                $this->redirect('/public/index.php?controller=CourseController&action=index');
            } else {
                echo "Có lỗi xảy ra khi cập nhật khóa học.";
            }
        }

        // Hiển thị form chỉnh sửa khóa học
        include '../app/views/courses/edit.php';
    }

    public function delete($id) {
        // Xóa khóa học theo ID
        if ($this->course->deleteCourse($id)) {
            // Điều hướng bằng JavaScript
            $this->redirect('/public/index.php?controller=CourseController&action=index');
        } else {
            echo "Có lỗi xảy ra khi xóa khóa học.";
        }
    }

    // Helper function để điều hướng bằng JavaScript
    private function redirect($url) {
        echo "<script>window.location.href = '$url';</script>";
        exit();
    }
}
?>
