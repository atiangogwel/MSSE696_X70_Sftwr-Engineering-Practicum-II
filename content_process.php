<?php
session_start();
include "FlashMessage.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in and has the necessary permissions
    if (isset($_SESSION['userid']) && isset($_SESSION['role']) && $_SESSION['role'] == 'instructor') {
        include('db_connection.php');

        // Function to handle file upload
        function uploadFile($uploadDir, $allowTypes)
        {
            $uploadedFile = $_FILES['file']['name'];
            $fileTmp = $_FILES['file']['tmp_name'];
            $fileType = $_FILES['file']['type'];
            $fileSize = $_FILES['file']['size'];
            $fileExt = strtolower(pathinfo($uploadedFile, PATHINFO_EXTENSION));

            $newFileName = uniqid() . '.' . $fileExt;
            $uploadPath = $uploadDir . $newFileName;

            if (in_array($fileExt, $allowTypes)) {
                if (move_uploaded_file($fileTmp, $uploadPath)) {
                    return $newFileName;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        // Get form data
        $courseId = $_POST['courseid'];
        $title = $_POST['title'];

        // File upload
        $uploadDir = 'uploads/';
        $allowTypes = array('pdf', 'doc', 'docx', 'ppt', 'pptx', 'txt', 'jpg', 'png', 'zip');
        $uploadedFile = uploadFile($uploadDir, $allowTypes);

        if ($uploadedFile) {
            // Insert data into the course_content table
            $insertQuery = "INSERT INTO course_content (courseid, title, file_path) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("iss", $courseId, $title, $uploadedFile);
            $stmt->execute();
            $stmt->close();

            $_SESSION['success_message'] = "Content uploaded successfully.";
        } else {
            $_SESSION['error_message'] = "File upload failed. Please check the file type and try again.";
        }

        $conn->close();
    } else {
        $_SESSION['error_message'] = "Unauthorized access.";
    }

    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit();
} else {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
     exit();
}
?>
