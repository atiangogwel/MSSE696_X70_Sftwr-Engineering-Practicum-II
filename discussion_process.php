<?php
session_start();
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['courseSelectModal'])) {
    // Get the selected course ID, topic, and post data from the form
    $courseId = $_POST['courseSelectModal'];
    $topic = $_POST['topic'];
    $postContent = $_POST['post'];

    // Get the user ID from the session
    $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;

    // Check if the user ID is available
    if ($userId !== null) {
        $insertPostQuery = "INSERT INTO posts (userID, courseID, topic, post) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertPostQuery);
        $stmt->bind_param("iiss", $userId, $courseId, $topic, $postContent);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Discussion posted successfully';
        } else {
            $_SESSION['error_message'] = 'Error posting discussion. Please try again.';
        }

        $stmt->close();
    } else {
        $_SESSION['error_message'] = 'User ID is not available. Please log in.';
    }

    $conn->close();
}

header("Location: " . $_SERVER["HTTP_REFERER"]);
exit();
?>
