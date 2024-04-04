<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in and has the necessary permissions
    if (isset($_SESSION['userid']) && isset($_SESSION['role']) && $_SESSION['role'] == 'instructor') {
        include('db_connection.php');

        // Get instructor ID from the session
        $instructorId = $_SESSION['userid'];

        // Check if the form fields for adding a new course are set
        if (isset($_POST['title'], $_POST['startdate'], $_POST['enddate'], $_POST['status'])) {
            // Get course details from the form
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $startDate = $_POST['startdate'];
            $endDate = $_POST['enddate'];
            $status = mysqli_real_escape_string($conn, $_POST['status']);

            // Validate and sanitize input data
            $instructorId = intval($instructorId);

            $insertCourseQuery = "INSERT INTO course (title, startdate, enddate, status, instructorID) 
                                  VALUES (?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($insertCourseQuery);
            $stmt->bind_param("ssssi", $title, $startDate, $endDate, $status, $instructorId);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = 'Course added successfully!';
            } else {
                $_SESSION['error_message'] = 'Error adding course: ' . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
        // Check if the form fields for updating an existing course are set
        elseif (isset($_POST['courseId'], $_POST['editTitle'], $_POST['editStartDate'], $_POST['editEndDate'], $_POST['editStatus'])) {
            // Get course details from the form
            $courseId = intval($_POST['courseId']);
            $title = mysqli_real_escape_string($conn, $_POST['editTitle']);
            $startDate = $_POST['editStartDate'];
            $endDate = $_POST['editEndDate'];
            $status = $_POST['editStatus'];

            // Validate and sanitize input data
            $courseId = intval($courseId);
            $instructorId = intval($instructorId);

            $updateCourseQuery = "UPDATE course 
                                  SET title = ?, startdate = ?, enddate = ?, status = ?
                                  WHERE courseid = ? AND instructorID = ?";

            $stmt = $conn->prepare($updateCourseQuery);
            $stmt->bind_param("ssssii", $title, $startDate, $endDate, $status, $courseId, $instructorId);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = 'Course updated successfully!';
            } else {
                $_SESSION['error_message'] = 'Error updating course: ' . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } elseif (isset($_POST['assignmentTitle'], $_POST['assignmentInstructions'], $_POST['dueDate'], $_POST['assignmentCourseId'])) {
            // Get assignment details from the form
            $assignmentTitle = mysqli_real_escape_string($conn, $_POST['assignmentTitle']);
            $assignmentInstructions = mysqli_real_escape_string($conn, $_POST['assignmentInstructions']);
            $dueDate = $_POST['dueDate'];
            $courseId = intval($_POST['assignmentCourseId']);

            // Validate and sanitize input data
            $courseId = intval($courseId);
            $instructorId = intval($instructorId);

            // Perform the assignment insertion into the database
            $insertAssignmentQuery = "INSERT INTO assignments (courseID, title, instructions, dueDate) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertAssignmentQuery);
            $stmt->bind_param("isss", $courseId, $assignmentTitle, $assignmentInstructions, $dueDate);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = 'Assignment created successfully!';
            } else {
                $_SESSION['error_message'] = 'Error creating assignment: ' . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            $_SESSION['error_message'] = 'One or more form fields are missing.';
        }

        // Close the database connection
        $conn->close();
    } else {
        $_SESSION['error_message'] = 'You do not have permission to perform this action.';
    }

    header("Location: " . $_SERVER["HTTP_REFERER"]);
}
?>
