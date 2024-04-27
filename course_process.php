<?php
session_start();

class CourseManagement {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addCourse($instructorId, $title, $startDate, $endDate, $status) {
        $insertCourseQuery = "INSERT INTO course (title, startdate, enddate, status, instructorID) 
                              VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($insertCourseQuery);
        $stmt->bind_param("ssssi", $title, $startDate, $endDate, $status, $instructorId);

        if ($stmt->execute()) {
            return 'Course added successfully!';
        } else {
            return 'Error adding course: ' . $stmt->error;
        }
    }

    public function updateCourse($courseId, $instructorId, $title, $startDate, $endDate, $status) {
        $updateCourseQuery = "UPDATE course 
                              SET title = ?, startdate = ?, enddate = ?, status = ?
                              WHERE courseid = ? AND instructorID = ?";
        $stmt = $this->conn->prepare($updateCourseQuery);
        $stmt->bind_param("ssssii", $title, $startDate, $endDate, $status, $courseId, $instructorId);

        if ($stmt->execute()) {
            return 'Course updated successfully!';
        } else {
            return 'Error updating course: ' . $stmt->error;
        }
    }

    public function addAssignment($courseId, $assignmentTitle, $assignmentInstructions, $dueDate) {
        $insertAssignmentQuery = "INSERT INTO assignments (courseID, title, instructions, dueDate) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($insertAssignmentQuery);
        $stmt->bind_param("isss", $courseId, $assignmentTitle, $assignmentInstructions, $dueDate);

        if ($stmt->execute()) {
            return 'Assignment created successfully!';
        } else {
            return 'Error creating assignment: ' . $stmt->error;
        }
    }

    public function handleAction($postData) {
        if (!isset($_SESSION['userid']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'instructor') {
            return 'You do not have permission to perform this action.';
        }

        if (!isset($postData['action'])) {
            return 'Action parameter is missing.';
        }

        // Get instructor ID from the session
        $instructorId = $_SESSION['userid'];

        switch ($postData['action']) {
            case 'addCourse':
                if (isset($postData['title'], $postData['startdate'], $postData['enddate'], $postData['status'])) {
                    return $this->addCourse(
                        $instructorId,
                        mysqli_real_escape_string($this->conn, $postData['title']),
                        $postData['startdate'],
                        $postData['enddate'],
                        mysqli_real_escape_string($this->conn, $postData['status'])
                    );
                } else {
                    return 'One or more form fields for adding a new course are missing.';
                }
                break;
            case 'updateCourse':
                if (isset($postData['courseId'], $postData['editTitle'], $postData['editStartDate'], $postData['editEndDate'], $postData['editStatus'])) {
                    return $this->updateCourse(
                        intval($postData['courseId']),
                        $instructorId,
                        mysqli_real_escape_string($this->conn, $postData['editTitle']),
                        $postData['editStartDate'],
                        $postData['editEndDate'],
                        $postData['editStatus']
                    );
                } else {
                    return 'One or more form fields for updating an existing course are missing.';
                }
                break;
            case 'addAssignment':
                if (isset($postData['assignmentTitle'], $postData['assignmentInstructions'], $postData['dueDate'], $postData['assignmentCourseId'])) {
                    return $this->addAssignment(
                        intval($postData['assignmentCourseId']),
                        mysqli_real_escape_string($this->conn, $postData['assignmentTitle']),
                        mysqli_real_escape_string($this->conn, $postData['assignmentInstructions']),
                        $postData['dueDate']
                    );
                } else {
                    return 'One or more form fields for adding an assignment are missing.';
                }
                break;
            default:
                return 'Invalid action.';
                break;
        }
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection code (assuming you have already included db_connection.php)
    include('db_connection.php');

    // Initialize the CourseManagement class
    $courseManagement = new CourseManagement($conn);

    // Handle the action based on POST data
    $message = $courseManagement->handleAction($_POST);

    // Set session message
    if (strpos($message, 'Error') !== false) {
        $_SESSION['error_message'] = $message;
    } else {
        $_SESSION['success_message'] = $message;
    }

    // Close the database connection
    $conn->close();

    // Redirect back to the previous page
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}
?>
