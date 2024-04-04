<?php
session_start();
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['contributionContent'], $_POST['postId'])) {
    // Get the user ID from the session
    $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;

    // Get the contribution content and post ID from the form
    $contributionContent = $_POST['contributionContent'];
    $postId = $_POST['postId'];

    if ($userId !== null) {
        // Insert the contribution into the contributions table
        $insertContributionQuery = "INSERT INTO contributions (userID, postID, content) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertContributionQuery);
        $stmt->bind_param("iis", $userId, $postId, $contributionContent);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Contribution added successfully';
        } else {
            $_SESSION['error_message'] = 'Error adding contribution. Please try again.';
        }

        $stmt->close();
    } else {
        $_SESSION['error_message'] = 'User ID is not available. Please log in.';
    }
}

$conn->close();
header("Location: " . $_SERVER["HTTP_REFERER"]);
exit();
?>
