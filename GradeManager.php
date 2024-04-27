<?php
session_start();
include('db_connection.php');

class GradeManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addGrade($userId, $courseId, $grade, $comment) {
        $insertGradeQuery = "INSERT INTO grades (userID, courseID, grade, comment) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($insertGradeQuery);
        $stmt->bind_param("iiis", $userId, $courseId, $grade, $comment);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Grade added successfully.';
            return true;
        } else {
            $_SESSION['error_message'] = 'Error adding grade: ' . $this->conn->error;
            return false;
        }

        $stmt->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gradeManagement = new GradeManagement($conn);

    // Retrieve data from the POST request
    $userId = $_POST['userID'];
    $courseId = $_POST['courseID'];
    $grade = $_POST['grade'];
    $comment = $_POST['comment'];

    // Call the addGrade method of the GradeManagement class
    if ($gradeManagement->addGrade($userId, $courseId, $grade, $comment)) {
        $response = ['success' => true, 'message' => 'Grade added successfully.'];
    } else {
        $response = ['success' => false, 'message' => 'Error adding grade.'];
    }

    // Return JSON response to the JavaScript
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
} else {
    // Handle non-POST requests (optional)
    header("HTTP/1.1 405 Method Not Allowed");
    exit();
}
?>
