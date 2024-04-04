<?php
session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the POST request
    $userId = $_POST['userID'];
    $courseId = $_POST['courseID'];
    $grade = $_POST['grade'];
    $comment = $_POST['comment'];

    // Validate and sanitize data if necessary

    // Insert the grade into the database
    $insertGradeQuery = "INSERT INTO grades (userID, courseID, grade, comment) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertGradeQuery);
    $stmt->bind_param("iiis", $userId, $courseId, $grade, $comment);

    if ($stmt->execute()) {
        $response = ['success' => true, 'message' => 'Grade added successfully.'];
    } else {
        $response = ['success' => false, 'message' => 'Error adding grade.'];
    }

    $stmt->close();
    $conn->close();

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
