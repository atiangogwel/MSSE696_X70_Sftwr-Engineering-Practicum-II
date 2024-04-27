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

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }
}

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new GradeManager($conn);

    // Retrieve data from the POST request
    $userId = $_POST['userID'];
    $courseId = $_POST['courseID'];
    $grade = $_POST['grade'];
    $comment = $_POST['comment'];

   

    // Add grade using the GradeManager class
    $response = $db->addGrade($userId, $courseId, $grade, $comment);

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
