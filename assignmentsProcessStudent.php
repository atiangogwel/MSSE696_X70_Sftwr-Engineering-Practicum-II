<?php
session_start();
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['courseId'])) {
        $courseId = $_POST['courseId'];

        // Fetch assignments for the selected course from the database
        $selectAssignmentsQuery = "SELECT * FROM assignments WHERE courseID = ?";
        $stmt = $conn->prepare($selectAssignmentsQuery);
        $stmt->bind_param("i", $courseId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Display assignments in Bootstrap cards
        if ($result->num_rows > 0) {
            while ($assignment = $result->fetch_assoc()) {
                $assignmentID = $assignment['assignmentID'];

                // Check the number of submission attempts
                $getSubmissionAttemptsQuery = "SELECT COUNT(DISTINCT submissionAttempt) AS submissionAttempts FROM submissions WHERE assignmentID = ? AND userID = ?";
                $stmtSubmissionAttempts = $conn->prepare($getSubmissionAttemptsQuery);
                $stmtSubmissionAttempts->bind_param("ii", $assignmentID, $_SESSION['userid']);
                $stmtSubmissionAttempts->execute();
                $resultSubmissionAttempts = $stmtSubmissionAttempts->get_result();

                if ($rowSubmissionAttempts = $resultSubmissionAttempts->fetch_assoc()) {
                    $submissionAttempts = $rowSubmissionAttempts['submissionAttempts'];

                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title" style="color: blue;">Assignment: ' . $assignment['title'] . '</h5>';
                    echo '<p class="card-text" style="color: red;">Due Date: ' . $assignment['dueDate'] . '</p>';
                    echo '<p class="card-text">Instructions: ' . $assignment['instructions'] . '</p>';
                    echo '<p class="card-text">Attempts: ' . $submissionAttempts . '</p>';

                    // Display "Re-submit" button if there are existing submissions, otherwise display "Submit" button
                    if ($submissionAttempts > 0) {
                        echo '<form action="assignmentsProcessStudent.php" method="post" enctype="multipart/form-data">';
                        echo '<input type="hidden" name="assignmentID" value="' . $assignmentID . '">';
                        echo '<input type="file" name="submissionFile" required>';
                        echo '<button type="submit" class="btn btn-warning">Re-submit</button>';
                        echo '</form>';
                    } else {
                        echo '<form action="assignmentsProcessStudent.php" method="post" enctype="multipart/form-data">';
                        echo '<input type="hidden" name="assignmentID" value="' . $assignmentID . '">';
                        echo '<input type="file" name="submissionFile" required>';
                        echo '<button type="submit" class="btn btn-primary">Submit</button>';
                        echo '</form>';
                    }

                    echo '</div>';
                    echo '</div>';
                }

                // Close the statement
                $stmtSubmissionAttempts->close();
            }
        } else {
            echo '<p>No assignments found for the selected course.</p>';
        }

        // Close the statement
        $stmt->close();
    } elseif (isset($_POST['assignmentID'])) {
        // Handle submission of assignments
        // Get data from the form
        $assignmentID = $_POST['assignmentID'];
        $userID = $_SESSION['userid']; 
        $submissionDate = date("Y-m-d H:i:s"); 
        $submissionFile = ''; 

        // Example: Handle file upload (make sure to implement proper security checks)
        if (isset($_FILES['submissionFile']) && $_FILES['submissionFile']['error'] === 0) {
            $uploadDir = 'uploads/'; 
            $uploadFile = $uploadDir . basename($_FILES['submissionFile']['name']);
            
            if (move_uploaded_file($_FILES['submissionFile']['tmp_name'], $uploadFile)) {
                $submissionFile = $uploadFile;
            } else {
                $_SESSION['error_message'] = 'Error submitting assignment. Please try again.';
                header("Location: " . $_SERVER["HTTP_REFERER"]);
                exit;
            }
        }

        // Insert submission data 
        $insertSubmissionQuery = "INSERT INTO submissions (assignmentID, userID, submissionDate, submissionFile) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSubmissionQuery);
        $stmt->bind_param("iiss", $assignmentID, $userID, $submissionDate, $submissionFile);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Submission successful!';
        } else {
            $_SESSION['error_message'] = 'Error submitting assignment. Please try again.';
        }

        // Close the statement
        $stmt->close();
        $conn->close();
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit;
    } else {
        $_SESSION['error_message'] = 'Invalid request: No course ID or assignment ID provided.';
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit;
    }
} else {
    $_SESSION['error_message'] = 'Invalid request: Method not allowed.';
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit;
}
?>
