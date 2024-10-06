<?php
require_once __DIR__ . '/../models/Grade.php';

class GradeController {
    private $gradeModel;

    public function __construct() {
        $this->gradeModel = new Grade();
    }

    public function index() {
        $grades = $this->gradeModel->getAllGrades();
        $view = __DIR__ . '/../views/grade/index.php';
        require_once __DIR__ . '/../views/layout.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->gradeModel->createGrade($_POST);
            header("Location: index.php");
            exit();
        }
        $view = __DIR__ . '/../views/grade/create.php';
        require_once __DIR__ . '/../views/layout.php';
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->gradeModel->updateGrade($id, $_POST);
            header("Location: index.php");
            exit();
        }

        $grade = $this->gradeModel->getGradeById($id);
        $view = __DIR__ . '/../views/grade/edit.php';
        require_once __DIR__ . '/../views/layout.php';
    }

    public function delete($id) {
        $this->gradeModel->deleteGrade($id);
        header("Location: index.php");
        exit();
    }
}
?>
