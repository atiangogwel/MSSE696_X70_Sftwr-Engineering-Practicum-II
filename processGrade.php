<?php
session_start();
include "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assignmentId'])) {
    $assignmentId = $_POST['assignmentId'];
    $submissions = fetchSubmissions($assignmentId, $conn);
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['download'])) {
    // Your existing file download code...
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submissionId'])) {
    // Insert data into the "grade" table
    $submissionId = $_POST['submissionId'];
    $grade = $_POST['grade'];
    $comments = $_POST['comments'];
    $studentID = $_POST['studentID'];

    // Check if a record already exists for the given submissionId
    $checkExistingQuery = "SELECT COUNT(*) FROM grades WHERE submissionID = ?";
    $stmtCheck = $conn->prepare($checkExistingQuery);
    $stmtCheck->bind_param("i", $submissionId);
    $stmtCheck->execute();
    $stmtCheck->bind_result($rowCount);
    $stmtCheck->fetch();
    $stmtCheck->close();

    if ($rowCount > 0) {
        // A record already exists for the given submissionId
        $_SESSION['error_message'] = 'A grade record already exists for this submission.';
    } else {
        $insertGradeQuery = "INSERT INTO grades (submissionID, grade, comments,userID) VALUES (?, ?, ?,?)";
        $stmt = $conn->prepare($insertGradeQuery);
        $stmt->bind_param("issi", $submissionId, $grade, $comments,$studentID);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Grade added successfully!';
        } else {
            $_SESSION['error_message'] = 'Error adding grade: ' . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['getSubmissionDetails']) && isset($_POST['submissionId'])) {
    // Fetch comments and grade for the given submissionId
    $submissionId = $_POST['submissionId'];

    $selectDetailsQuery = "SELECT grade, comments FROM grades WHERE submissionID = ?";
    $stmt = $conn->prepare($selectDetailsQuery);
    $stmt->bind_param("i", $submissionId);
    $stmt->execute();
    $stmt->bind_result($grade, $comments);
    $stmt->fetch();
    $stmt->close();

    // Prepare response data
    $response = [
        'grade' => $grade,
        'comments' => $comments
    ];

    // Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
} else {
    $_SESSION['error_message'] = 'Invalid request: ' . $stmt->error;
    exit();
}
?>
