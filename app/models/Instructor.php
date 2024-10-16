<?php
class Instructor {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Phương thức lấy danh sách giảng viên, có hỗ trợ tìm kiếm
    public function getInstructors($searchTerm = '') {
        if (!empty($searchTerm)) {
            $query = "SELECT * FROM instructors WHERE name LIKE :searchTerm 
                      OR subject_taught LIKE :searchTerm 
                      OR degree LIKE :searchTerm";
            $stmt = $this->db->prepare($query);
            $searchTerm = '%' . $searchTerm . '%';
            $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
        } else {
            $query = "SELECT * FROM instructors";
            $stmt = $this->db->prepare($query);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Phương thức lấy thông tin một giảng viên bằng ID
    public function getInstructorById($id) {
        $query = "SELECT * FROM instructors WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Phương thức tạo giảng viên mới
    public function createInstructor($name, $subject_taught, $degree) {
        $query = "INSERT INTO instructors (name, subject_taught, degree) 
                  VALUES (:name, :subject_taught, :degree)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':subject_taught', $subject_taught);
        $stmt->bindParam(':degree', $degree);
        
        return $stmt->execute();
    }

    // Phương thức cập nhật giảng viên
    public function updateInstructor($id, $name, $subject_taught, $degree) {
        $query = "UPDATE instructors 
                  SET name = :name, subject_taught = :subject_taught, degree = :degree 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':subject_taught', $subject_taught);
        $stmt->bindParam(':degree', $degree);
        
        return $stmt->execute();
    }

    // Phương thức xóa giảng viên
    public function deleteInstructor($id) {
        $query = "DELETE FROM instructors WHERE id = :id";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
?>
