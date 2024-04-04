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
        <h2>Instructor Courses</h2>
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCourseModal">Add New Course</button>
        <table class="table table-striped mt-3">
            <thead style="font-size: 1em; background-color: #e67e22; color:white">
                <tr>
                    <th>Course ID</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($course = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $course['courseid']; ?></td>
                        <td><?php echo $course['title']; ?></td>
                        <td><?php echo $course['startdate']; ?></td>
                        <td><?php echo $course['enddate']; ?></td>
                        <td><?php echo $course['status']; ?></td>
                        <td>
                        <button style="background-color: #967db8; color:white" type="button" class="btn btn-primary btn-sm edit-course-btn"
                            data-bs-toggle="modal" data-bs-target="#editCourseModal"
                            data-course-id="<?php echo $course['courseid']; ?>"
                            data-course-title="<?php echo $course['title']; ?>"
                            data-course-start-date="<?php echo $course['startdate']; ?>"
                            data-course-end-date="<?php echo $course['enddate']; ?>"
                            data-course-status="<?php echo $course['status']; ?>">
                        Edit
                        </button> 
                        
                        <button type="button" style="background-color: #967db8; color:white" class="btn btn-info btn-sm view-enrolled-btn" data-bs-toggle="modal" data-bs-target="#viewEnrolledStudentsModal" data-course-id="<?php echo $course['courseid']; ?>">Enrolled Students</button>
                        <button type="button" style="background-color: #967db8; color:white" class="btn btn-success btn-sm create-assignment-btn" data-bs-toggle="modal" data-bs-target="#createAssignmentModal" data-course-id="<?php echo $course['courseid']; ?>">Create Assignment</button>
                        </td>
                    </tr>
                <?php endwhile; ?>

                <?php if ($result->num_rows == 0) : ?>
                    <tr>
                        <td colspan="6">No courses found for the instructor.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="course_process.php" method="post">
                    <div class="mb-3">
                        <label for="editTitle" class="form-label">Title:</label>
                        <input type="text" class="form-control" name="editTitle" id="editTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStartDate" class="form-label">Start Date:</label>
                        <input type="date" class="form-control" name="editStartDate" id="editStartDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEndDate" class="form-label">End Date:</label>
                        <input type="date" class="form-control" name="editEndDate" id="editEndDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status:</label>
                        <select class="form-select" name="editStatus" id="editStatus" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <input type="hidden" name="courseId" id="editCourseId">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCourseModalLabel">Add New Course</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="course_process.php" method="post">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title:</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="Enter course title" required>
                            </div>
                            <div class="mb-3">
                                <label for="startdate" class="form-label">Start Date:</label>
                                <input type="date" class="form-control" name="startdate" id="startdate" required>
                            </div>
                            <div class="mb-3">
                                <label for="enddate" class="form-label">End Date:</label>
                                <input type="date" class="form-control" name="enddate" id="enddate" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status:</label>
                                <select class="form-select" name="status" id="status" aria-label="Select Status" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Course</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="createAssignmentModal" tabindex="-1" aria-labelledby="createAssignmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAssignmentModalLabel">Create Assignment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="course_process.php" method="post">
                    <div class="mb-3">
                        <label for="assignmentTitle" class="form-label">Assignment Title:</label>
                        <input type="text" class="form-control" name="assignmentTitle" id="assignmentTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="assignmentInstructions" class="form-label">Instructions:</label>
                        <textarea class="form-control" name="assignmentInstructions" id="assignmentInstructions" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="dueDate" class="form-label">Due Date:</label>
                        <input type="date" class="form-control" name="dueDate" id="dueDate" required>
                    </div>

                    <!-- Hidden field to store the course ID -->
                    <input type="hidden" name="assignmentCourseId" id="assignmentCourseId">

                    <button type="submit" class="btn btn-primary">Create Assignment</button>
                </form>
            </div>
        </div>
    </div>
</div>



    <!-- modl for view enrolled students -->
<div class="modal fade" id="viewEnrolledStudentsModal" tabindex="-1" aria-labelledby="viewEnrolledStudentsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewEnrolledStudentsModalLabel">Enrolled Students</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <!-- sample student Data -->
                    <li class="list-group-item"><a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#studentDetailsModal">Student 1</a></li>
                    <li class="list-group-item"><a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#studentDetailsModal">Student 2</a></li>
                    <li class="list-group-item"><a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#studentDetailsModal">Student 3</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal for Student Details -->
<div class="modal fade" id="studentDetailsModal" tabindex="-1" aria-labelledby="studentDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentDetailsModalLabel">Student Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 id="studentName">Abdi Mohamed</h4>

                <!-- Grading Section -->
                <div class="mb-3">
                    <label for="gradeSelect" class="form-label">Select Grade:</label>
                    <select class="form-select" id="gradeSelect">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="F">F</option>
                    </select>
                </div>

                <!-- Comment Section -->
                <div class="mb-3">
                    <label for="commentTextarea" class="form-label">Comments:</label>
                    <textarea class="form-control" id="commentTextarea" rows="4" placeholder="Enter comments here"></textarea>
                </div>
                <button type="button" class="btn btn-primary" id="gradeSubmitBtn">Grade</button>
            </div>
        </div>
    </div>
</div>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
</body>
<script>
    // JavaScript to handle button click and populate modal fields
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.edit-course-btn');

        editButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                document.getElementById('editCourseId').value = button.getAttribute('data-course-id');
                document.getElementById('editTitle').value = button.getAttribute('data-course-title');
                document.getElementById('editStartDate').value = button.getAttribute('data-course-start-date');
                document.getElementById('editEndDate').value = button.getAttribute('data-course-end-date');
                document.getElementById('editStatus').value = button.getAttribute('data-course-status');
            });
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const viewEnrolledBtns = document.querySelectorAll('.view-enrolled-btn');

    viewEnrolledBtns.forEach(button => {
        button.addEventListener('click', function () {
            const courseId = button.getAttribute('data-course-id');
            fetchEnrolledStudents(courseId);
        });
    });
});

function fetchEnrolledStudents(courseId) {
    fetch(`fetch_enrolled_students.php?courseId=${courseId}`)
    .then(response => response.json())
    .then(data => {
        displayEnrolledStudents(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function displayEnrolledStudents(students) {
    const modalBody = document.querySelector('#viewEnrolledStudentsModal .modal-body .list-group');
    modalBody.innerHTML = ''; // Clear previous entries
    
    if (students.length === 0) {
        const noStudentElement = document.createElement('li');
        noStudentElement.classList.add('list-group-item');
        noStudentElement.textContent = 'No students found for this course.';
        modalBody.appendChild(noStudentElement);
    } else {
        students.forEach(student => {
            const studentElement = document.createElement('li');
            studentElement.classList.add('list-group-item');
            
            // Use data attributes to store student details
            studentElement.setAttribute('data-user-id', student.userId);
            studentElement.setAttribute('data-first-name', student.firstname);
            studentElement.setAttribute('data-last-name', student.lastname);

            studentElement.innerHTML = `${student.firstname} ${student.lastname}`;
            modalBody.appendChild(studentElement);

            // Add a click event listener to the student element
            studentElement.addEventListener('click', function () {
                // Retrieve student details from data attributes
                const userId = studentElement.getAttribute('data-user-id');
                const firstName = studentElement.getAttribute('data-first-name');
                const lastName = studentElement.getAttribute('data-last-name');

                // Populate student details modal
                document.getElementById('studentName').innerText = `${firstName} ${lastName}`;

            });
        });
    }
}
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const createAssignmentBtns = document.querySelectorAll('.create-assignment-btn');

        createAssignmentBtns.forEach(button => {
            button.addEventListener('click', function () {
                const courseId = button.getAttribute('data-course-id');

                // Set the courseId in the modal form
                document.getElementById('assignmentCourseId').value = courseId;

                // Open the "Create Assignment" modal
                const createAssignmentModal = new bootstrap.Modal(document.getElementById('createAssignmentModal'));
                createAssignmentModal.show();
            });
        });
    });
</script>



</html>
