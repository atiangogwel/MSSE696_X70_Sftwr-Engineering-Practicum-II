<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['courseId'])) {
    echo "Script is executing."; 

    // Get the user ID from the session
    $userId = $_SESSION['userid'];

    // Get the course ID from the AJAX request
    $courseId = $_POST['courseId'];

    include('db_connection.php');

    // Check if the user is already enrolled in the course
    $checkEnrollmentQuery = "SELECT * FROM enrollments WHERE userID = ? AND courseID = ?";
    $stmtCheck = $conn->prepare($checkEnrollmentQuery);
    $stmtCheck->bind_param("ii", $userId, $courseId);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        echo "You are already enrolled in this course.";
    } else {
        // Enroll the user in the course
        $enrollQuery = "INSERT INTO enrollments (userID, courseID, enrollmentDate) VALUES (?, ?, NOW())";
        $stmtEnroll = $conn->prepare($enrollQuery);
        $stmtEnroll->bind_param("ii", $userId, $courseId);

        if ($stmtEnroll->execute()) {
            echo "Enrollment successful!";
        } else {
            echo "Error enrolling in the course: " . $stmtEnroll->error;
        }

        $stmtEnroll->close();
    }

    $stmtCheck->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>