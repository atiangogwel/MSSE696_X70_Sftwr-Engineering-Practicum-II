<?php
session_start();
include('db_connection.php');
include "FlashMessage.php";

// Get the user ID from the session
$userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;

// Initialize an array to store enrolled courses
$enrolledCourses = [];

if ($userId) {
    $selectCoursesQuery = "SELECT courseid, title FROM course WHERE courseid IN (
        SELECT courseID FROM enrollments WHERE userID = ?
    )";

    $stmt = $conn->prepare($selectCoursesQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    // Check if there are any courses
    if ($result->num_rows > 0) {
        while ($course = $result->fetch_assoc()) {
            $enrolledCourses[] = $course;
        }
    }
    $conn->close();
} else {
    // Handle the case when user ID is not set in the session
    header("Location: login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['courseId'])) {
    $courseId = $_POST['courseId'];

    // Fetch assignments for the selected course 
    $selectAssignmentsQuery = "SELECT * FROM assignments WHERE courseID = ?";
    $stmt = $conn->prepare($selectAssignmentsQuery);
    $stmt->bind_param("i", $courseId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are any assignments
    if ($result->num_rows > 0) {
        $assignmentNumber = 1;
        while ($assignment = $result->fetch_assoc()) {
            $assignmentTitle = $assignment['title'];
            echo '<p><a href="#" onclick="showAssignmentDetails(' . $assignment['assignmentID'] . ')">Assignment ' . $assignmentNumber . ': ' . $assignmentTitle . '</a></p>';
            $assignmentNumber++;
        }
    } else {
        echo '<p>No assignments found for the selected course.</p>';
    }

    $stmt->close();
    $conn->close(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Assignments</title>
</head>
<body>
    <div class="container mt-4">
        <h3>Select a Course to View assignments</h3>

        <!-- Dropdown to select a course -->
        <form action="process_selected_course.php" method="post">
            <div class="mb-3">
                <label for="courseSelect" class="form-label">Select Course:</label>
                <select class="form-select w-50" name="courseSelect" id="courseSelect" required>
                    <option value="" disabled selected>Select a Course</option>

                    <?php foreach ($enrolledCourses as $course) : ?>
                        <option value="<?php echo $course['courseid']; ?>"><?php echo $course['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

        </form>
    </div>
    <div id="assignmentsContainer" class="container mt-4">
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#courseSelect').change(function () {
                var courseId = $(this).val();

                $.ajax({
                    url: 'assignmentsProcessStudent.php', 
                    method: 'POST',
                    data: { courseId: courseId },
                    success: function (data) {
                        $('#assignmentsContainer').html(data);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });

        function showAssignmentDetails(assignmentId) {
    
        }
    </script>
</body>
</html>

</html>
