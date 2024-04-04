<?php
include('db_connection.php');

if (isset($_GET['courseid'])) {
    $courseId = $_GET['courseid'];

    // Check if contentid is provided for download
    if (isset($_GET['contentid'])) {
        $contentId = $_GET['contentid'];

        // Fetch file path based on the content ID
        $selectFilePathQuery = "SELECT file_path FROM course_content WHERE contentid = ? AND courseid = ?";
        $stmt = $conn->prepare($selectFilePathQuery);
        $stmt->bind_param("ii", $contentId, $courseId);
        $stmt->execute();
        $stmt->bind_result($filePath);

        if ($stmt->fetch()) {
            // Set headers for file download
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($filePath));
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit(); 
        } else {
            echo "File not found";
        }

        $stmt->close();
    } else {
        // Fetch content details based on the course ID
        $selectContentQuery = "SELECT * FROM course_content WHERE courseid = ?";
        $stmt = $conn->prepare($selectContentQuery);
        $stmt->bind_param("i", $courseId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Display content details and download link
        if ($result->num_rows > 0) {
            echo '<div class="container mt-4">';
            while ($content = $result->fetch_assoc()) {
                echo '<div class="border p-3 mb-3">';
                echo '<strong>Title:</strong> ' . $content['title'] . '<br>';
                echo '<input type="hidden" name="file_path" value="' . $content['file_path'] . '">';
                echo '<strong>Upload Date:</strong> ' . $content['upload_date'] . '<br>';
                echo '<input type="hidden" name="contentid" value="' . $content['contentid'] . '">';
                // Download link
                echo '<a href="get_content_details.php?courseid=' . $courseId . '&contentid=' . $content['contentid'] . '">Download</a>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo "No content found for this course.";
        }

        $stmt->close();
    }

    $conn->close();
} else {
    echo "Invalid request";
}
?>
