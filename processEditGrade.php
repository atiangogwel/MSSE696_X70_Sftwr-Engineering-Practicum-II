<?php
session_start();
include "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submissionId'])) {
    $submissionId = $_POST['submissionId'];

    // Query to retrieve comments and grade for the given submission ID
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
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $submissionId = $_POST['editSubmissionId'];
    $newGrade = $_POST['editGrade'];
    $comments = $_POST['editComments'];

    $updateGradeQuery = "UPDATE grades SET grade = ?, comments = ? WHERE submissionID = ?";
    $stmt = $conn->prepare($updateGradeQuery);
    $stmt->bind_param("ssi", $newGrade, $comments, $submissionId);

    if ($stmt->execute()) {
        // Successfully updated grade
        $stmt->close();
        $conn->close();

        session_start();
        $_SESSION['success_message'] = 'Grade updated successfully.';
        
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    } else {
        session_start();
        $_SESSION['error_message'] = 'Failed to update the grade.';
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    }
} else {
    session_start();
    $_SESSION['error_message'] = 'Invalid access.';
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit();
}

// Close the database connection
$conn->close();
?>
