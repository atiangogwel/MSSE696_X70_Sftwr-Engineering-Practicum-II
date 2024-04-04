<?php
session_start();
include('db_connection.php');

// Get the user ID from the session
$userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;

// Query for all courses
$sqlAllCourses = "SELECT course.courseid, course.title, course.instructorID, users.firstname AS instructor_firstname, users.lastname AS instructor_lastname
                  FROM course
                  INNER JOIN users ON course.instructorID = users.userid";
$resultAllCourses = $conn->query($sqlAllCourses);
$coursesAll = $resultAllCourses ? $resultAllCourses->fetch_all(MYSQLI_ASSOC) : [];

// Query for enrolled courses
if ($userId !== null) {
    $sqlEnrolledCourses = "SELECT course.courseid, course.title, course.instructorID, users.firstname AS instructor_firstname, users.lastname AS instructor_lastname
                           FROM course
                           INNER JOIN users ON course.instructorID = users.userid
                           INNER JOIN enrollments ON course.courseid = enrollments.courseID
                           WHERE enrollments.userID = ?";
    $stmtEnrolledCourses = $conn->prepare($sqlEnrolledCourses);
    $stmtEnrolledCourses->bind_param("i", $userId);
    $stmtEnrolledCourses->execute();
    $resultEnrolledCourses = $stmtEnrolledCourses->get_result();
    $coursesEnrolled = $resultEnrolledCourses ? $resultEnrolledCourses->fetch_all(MYSQLI_ASSOC) : [];
    $stmtEnrolledCourses->close();
}
// check if a course is enrolled
function isEnrolled($enrolledCourses, $courseId) {
    foreach ($enrolledCourses as $enrolledCourse) {
        if ($enrolledCourse['courseid'] == $courseId) {
            return true;
        }
    }
    return false;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Courses</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="myTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="allCourses-tab" data-toggle="tab" href="#allCourses" role="tab" aria-controls="allCourses" aria-selected="true">All Courses</a>
        </li>
        <?php if ($userId !== null) : ?>
            <li class="nav-item">
                <a class="nav-link" id="enrolledCourses-tab" data-toggle="tab" href="#enrolledCourses" role="tab" aria-controls="enrolledCourses" aria-selected="false">Enrolled Courses</a>
            </li>
        <?php endif; ?>
    </ul>

    <div class="tab-content">
        <!-- All Courses Tab -->
        <div class="tab-pane fade show active" id="allCourses" role="tabpanel" aria-labelledby="allCourses-tab">
    <h2>All Courses</h2>
    <table class="table table-bordered">
        <thead class="table-secondary">
        <tr>
            <th>Course ID</th>
            <th>Course Title</th>
            <th>Instructor</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($coursesAll as $course) : ?>
            <tr class="table-success">
                <td><?= $course['courseid'] ?></td>
                <td><?= $course['title'] ?></td>
                <td><?= $course['instructor_firstname'] . ' ' . $course['instructor_lastname'] ?></td>
                <td>
                    <?php if ($userId !== null && !isEnrolled($coursesEnrolled, $course['courseid'])) : ?>
                        <button style="background-color:#; color: white" class="btn btn-info btn-sm enroll-btn" data-course-id="<?= $course['courseid'] ?>">Enroll</button>
                    <?php else : ?>
                        <button class="btn btn-info btn-sm" disabled>Enrolled</button>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

        <!-- Enrolled Courses Tab -->
        <?php if ($userId !== null) : ?>
            <div class="tab-pane fade" id="enrolledCourses" role="tabpanel" aria-labelledby="enrolledCourses-tab">
                <h2>My Enrolled Courses</h2>
                <table class="table table-striped">
        <thead class="table-secondary">
                    <tr>
                        <th>Course ID</th>
                        <th>Course Title</th>
                        <th>Instructor</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($coursesEnrolled as $course) : ?>
                        <tr class="table-success">
                            <td><?= $course['courseid'] ?></td>
                            <td><?= $course['title'] ?></td>
                            <td><?= $course['instructor_firstname'] . ' ' . $course['instructor_lastname'] ?></td>
                            <td>
                            <button type="button" class="btn btn-info btn-sm view-content-btn" data-bs-toggle="modal" data-bs-target="#ViewContent" data-course-id="<?php echo $course['courseid']; ?>">
                            Materials
                        </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
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



<!-- Bootstrap JS and jQuery (full version) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        $('.enroll-btn').click(function () {
            // Get the course ID from the data attribute
            var courseId = $(this).data('course-id');

            // Perform AJAX request to enroll in the course
            $.ajax({
                type: 'POST',
                url: 'enroll.php', 
                data: {courseId: courseId},
                success: function (response) {
                    alert(response);
                },
                error: function (error) {
                    alert('Error enrolling in the course.');
                }
            });
        });
    });
</script>
<script>
    // JavaScript function to update the hidden input field in the modal
    function updateCourseIdForUpload(courseId) {
        document.getElementById('courseIdForUpload').value = courseId;
        document.getElementById('courseIdDisplay').innerText = courseId;
    }

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
        // AJAX request to fetch content details
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

</body>
</html>
