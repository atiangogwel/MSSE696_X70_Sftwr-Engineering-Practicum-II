<?php
include('db_connection.php');
include "FlashMessage.php";
if (isset($_GET['courseid'])) {
    $courseId = $_GET['courseid'];

    // Fetch content details based on the course ID
    $selectContentQuery = "SELECT * FROM course_content WHERE courseid = ?";
    $stmt = $conn->prepare($selectContentQuery);
    $stmt->bind_param("i", $courseId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display content details and download link
    while ($content = $result->fetch_assoc()) {
        echo '<strong>Title:</strong> ' . $content['title'] . '<br>';
        echo '<strong>File Path:</strong> ' . $content['file_path'] . '<br>';
        echo '<strong>Upload Date:</strong> ' . $content['upload_date'] . '<br>';
        echo '<strong>Content ID</strong> ' . $content['contentid'] . '<br>';
    }

    $stmt->close();
    $conn->close();
} 

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

    // Close the statement
    $stmt->close();
    $conn->close();
} else {
    header("Location: login.php");
    exit();
}
//get students associated with a given course
?>



<!DOCTYPE html>
<html lang="en">

<head>
</head>
<body>
<div class="container mt-4">
    <h2>Course Content</h2>
    <table class="table table-striped mt-3">
        <thead style="font-size: 1em; background-color: #e67e22; color:white">
            <tr>
                <th>Course ID</th>
                <th>Title</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($course = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $course['courseid']; ?></td>
                    <td><?php echo $course['title']; ?></td>
                    <td>
                        <button type="button" style="background-color: #967db8; color:white" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#UploadContentModal" onclick="updateCourseIdForUpload(<?php echo $course['courseid']; ?>)">
                            New
                        </button>
                        <button type="button" style="background-color: #967db8; color:white" class="btn btn-info btn-sm view-content-btn" data-bs-toggle="modal" data-bs-target="#ViewContent" data-course-id="<?php echo $course['courseid']; ?>">
                            View
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>
            <?php if ($result->num_rows == 0) : ?>
                <tr>
                    <td colspan="3">No courses found for the instructor.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<!-- Upload Content Modal -->
<div class="modal fade" id="UploadContentModal" tabindex="-1" aria-labelledby="UploadContentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UploadContentModalLabel">Upload Course Content</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="content_process.php" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="courseid" id="courseIdForUpload">
                    <div class="form-group">
                        <label for="title">Content Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="file">File</label>
                        <input type="file" class="form-control-file" id="file" name="file" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="uploadButton">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- View Content Modal -->
<div class="modal fade" id="ViewContent" tabindex="-1" aria-labelledby="ViewContentLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ViewContentLabel">View Course Content</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="contentDetails">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



    
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>
</html>

<script>
    // JavaScript function to update the hidden input field in the modal
    function updateCourseIdForUpload(courseId) {
        document.getElementById('courseIdForUpload').value = courseId;
        document.getElementById('courseIdDisplay').innerText = courseId;
    }

    // Event listener for the "New" button to update the course ID in the modal
    document.addEventListener('DOMContentLoaded', function () {
        var newButtons = document.querySelectorAll('.btn.btn-primary.btn-sm');
        newButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var courseId = this.closest('tr').querySelector('.btn-danger.delete-content-btn').getAttribute('data-course-id');
                updateCourseIdForUpload(courseId);
            });
        });
    });
    
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var viewButtons = document.querySelectorAll('.btn.btn-info.btn-sm.view-content-btn');
        viewButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var courseId = this.getAttribute('data-course-id');
                loadContentDetails(courseId);
            });
        });
    });

    function loadContentDetails(courseId) {
        // Make an AJAX request to fetch content details
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // Update the modal body with content details
                document.getElementById('contentDetails').innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "get_content_details.php?courseid=" + courseId, true);
        xhttp.send();
    }
</script>


