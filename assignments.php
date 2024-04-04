<?php
session_start();
include "FlashMessage.php";

// Check if the user is logged in and has the necessary permissions
if (isset($_SESSION['userid']) && isset($_SESSION['role']) && $_SESSION['role'] == 'instructor') {
    include('db_connection.php');

    // Get instructor ID from the session
    $instructorId = $_SESSION['userid'];

    // Fetch courses for the instructor from the database
    $selectCoursesQuery = "SELECT * FROM course WHERE instructorID = ?";
    $stmt = $conn->prepare($selectCoursesQuery);
    $stmt->bind_param("i", $instructorId);
    $stmt->execute();
    $result = $stmt->get_result();

    $stmt->close();

} else {
    header("Location: login.php");
    exit();
}

// Check if the form has been submitted with courseId
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

    // Close the statement
    $stmt->close();
    $conn->close(); 
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Assignments</title>
    </head>
    <body>
        <div class="container mt-4">
            <h2>Assingments</h2>
            <!-- Dropdown to select a course -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3">
                    <label for="courseSelect" class="form-label">Select Course:</label>
                    <select class="form-select w-50" name="courseId" id="courseSelect" required>
                        <option value="" disabled selected>Select a Course</option>
                        <?php while ($course = $result->fetch_assoc()) : ?>
                            <option value="<?php echo $course['courseid']; ?>"><?php echo $course['title']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </form>
        </div>
        <div id="assignmentsContainer" class="mt-4">
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    </body>
    <script>
        $(document).ready(function () {
            $('#courseSelect').change(function () {
                var courseId = $(this).val();
                $.ajax({
                    url: 'assignments.php',
                    method: 'POST',
                    data: { courseId: courseId },
                    success: function (data) {
                        // Replace the content of a div with the fetched assignments
                        $('#assignmentsContainer').html(data);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });

          function showAssignmentDetails(assignmentId) {
            $.ajax({
                url: 'getSubmissions.php',
                method: 'POST',
                data: { assignmentId: assignmentId },
                success: function (data) {
                    // Replace the content of a div with the fetched submissions
                    $('#assignmentsContainer').html(data);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
    </html>
    <?php
}
?>
