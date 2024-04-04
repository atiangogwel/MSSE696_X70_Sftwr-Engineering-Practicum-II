<?php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['courseId'])) {
    $courseId = $_POST['courseId'];

    $selectDiscussionsQuery = "SELECT posts.*, users.firstname, users.lastname
                               FROM posts
                               JOIN users ON posts.userID = users.userid
                               WHERE posts.courseID = ?";
    $stmt = $conn->prepare($selectDiscussionsQuery);
    $stmt->bind_param("i", $courseId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $discussions = [];

    // Check if there are any discussions
    if ($result->num_rows > 0) {
        while ($discussion = $result->fetch_assoc()) {
            // Fetch contributions for each post
            $selectContributionsQuery = "SELECT contributions.*, users.firstname, users.lastname
                                         FROM contributions
                                         JOIN users ON contributions.userID = users.userid
                                         WHERE contributions.postID = ?";
            $stmtContributions = $conn->prepare($selectContributionsQuery);
            $stmtContributions->bind_param("i", $discussion['postID']);
            $stmtContributions->execute();
            $resultContributions = $stmtContributions->get_result();
            $stmtContributions->close();

            $contributions = [];

            // Check if there are any contributions
            if ($resultContributions->num_rows > 0) {
                while ($contribution = $resultContributions->fetch_assoc()) {
                    $contributions[] = $contribution;
                }
            }

            // Add contributions to the discussion array
            $discussion['contributions'] = $contributions;

            $discussions[] = $discussion;
        }
    }

    // Output discussions as JSON
    header('Content-Type: application/json');
    echo json_encode($discussions);
}

$conn->close();
?>
