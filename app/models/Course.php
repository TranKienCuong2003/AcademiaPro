<?php

class Course {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Phương thức lấy danh sách khóa học, có hỗ trợ tìm kiếm
    public function getCourses($searchTerm = '') {
        if (!empty($searchTerm)) {
            $query = "SELECT * FROM courses WHERE course_name LIKE :searchTerm";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
        } else {
            $query = "SELECT * FROM courses";
            $stmt = $this->db->prepare($query);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Phương thức lấy thông tin một khóa học bằng ID
    public function getCourseById($id) {
        $query = "SELECT * FROM courses WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Phương thức tạo khóa học mới
    public function createCourse($course_name, $credits) {
        $query = "INSERT INTO courses (course_name, credits) VALUES (:course_name, :credits)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':course_name', $course_name);
        $stmt->bindParam(':credits', $credits);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Phương thức cập nhật khóa học
    public function updateCourse($id, $course_name, $credits) {
        $query = "UPDATE courses SET course_name = :course_name, credits = :credits WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':course_name', $course_name);
        $stmt->bindParam(':credits', $credits);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Phương thức xóa khóa học
    public function deleteCourse($id) {
        $query = "DELETE FROM courses WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
