<?php
require_once __DIR__ . '/../config/Database.php';

class Grade {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    public function getAllGrades() {
        $query = "SELECT * FROM grades";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGradeById($id) {
        $query = "SELECT * FROM grades WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createGrade($data) {
        $query = "INSERT INTO grades (student_id, course_id, grade, semester, exam_date) VALUES (:student_id, :course_id, :grade, :semester, :exam_date)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $data['student_id']);
        $stmt->bindParam(':course_id', $data['course_id']);
        $stmt->bindParam(':grade', $data['grade']);
        $stmt->bindParam(':semester', $data['semester']);
        $stmt->bindParam(':exam_date', $data['exam_date']);
        return $stmt->execute();
    }

    public function updateGrade($id, $data) {
        $query = "UPDATE grades SET student_id = :student_id, course_id = :course_id, grade = :grade, semester = :semester, exam_date = :exam_date WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':student_id', $data['student_id']);
        $stmt->bindParam(':course_id', $data['course_id']);
        $stmt->bindParam(':grade', $data['grade']);
        $stmt->bindParam(':semester', $data['semester']);
        $stmt->bindParam(':exam_date', $data['exam_date']);
        return $stmt->execute();
    }

    public function deleteGrade($id) {
        $query = "DELETE FROM grades WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>