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
    <style>
        .primary-post-card {
    background-color: #f0f0f0; 
}
    </style>
</head>
<body>
    <div class="container mt-4">
        <h3>Select a Course to View Discussions</h3>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#startDiscussionModal">
            Start a Discussion
        </button>

        <!-- Dropdown to select a course -->
        <form action="process_selected_course.php" method="post" id="courseForm">
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

    <!-- Container to display discussions -->
    <div id="discussionsContainer" class="container mt-4">
    </div>
</div>
 

    <div class="modal fade" id="startDiscussionModal" tabindex="-1" role="dialog" aria-labelledby="startDiscussionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="startDiscussionModalLabel">Start a Discussion</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="discussion_process.php" method="post">
                    <div class="mb-3">
                        <label for="courseSelectModal" class="form-label">Selected Course:</label>
                        <select class="form-select w-100" name="courseSelectModal" id="courseSelectModal" required>
                            <option value="" disabled selected>Select a Course</option>
                            <?php foreach ($enrolledCourses as $course) : ?>
                                <option value="<?php echo $course['courseid']; ?>"><?php echo $course['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="topic" class="form-label">Topic:</label>
                        <input type="text" class="form-control" id="topic" name="topic" required>
                    </div>
                    <div class="mb-3">
                        <label for="post" class="form-label">Post:</label>
                        <textarea class="form-control" id="post" name="post" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Discussion</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- modal for contribution -->
<div class="modal fade" id="contributeModal" tabindex="-1" role="dialog" aria-labelledby="contributeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contributeModalLabel">Contribute to Discussion</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="contributeForm" action="process_contribution.php" method="post">
                    <div class="mb-3">
                        <label for="contributionContent" class="form-label">Contribution:</label>
                        <textarea class="form-control" name="contributionContent" id="contributionContent" rows="3" required></textarea>
                    </div>
                    <input type="hidden" name="postId" id="postId" value="">
                    <button type="submit" class="btn btn-primary">Submit Contribution</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </form>
                
            </div>
        </div>
    </div>
</div>





<script>
    // Function to submit the contribution
    function submitContribution(postId) {
    document.getElementById('postId').value = postId;
    document.getElementById('contributeForm').submit();
}
    document.getElementById('courseSelectModal').addEventListener('change', function () {
        document.getElementById('selectedCourseText').textContent = 'Selected Course ID: ' + this.value;
    });
</script>


<script>
    document.getElementById('courseSelectModal').addEventListener('change', function () {
        document.getElementById('selectedCourseText').textContent = 'Selected Course ID: ' + this.value;
    });
</script>

<script>
    document.getElementById('courseSelect').addEventListener('change', function () {
        var courseId = this.value;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var discussions = JSON.parse(xhr.responseText);
                displayDiscussions(discussions);
            }
        };

        xhr.open('POST', 'get_discussions.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('courseId=' + courseId);
    });

    function displayDiscussions(discussions) {
    var discussionsContainer = document.getElementById('discussionsContainer');
    discussionsContainer.innerHTML = '';

    if (discussions.length > 0) {
        discussions.forEach(function (discussion) {
            // Display a card for the primary post and contributions
            var cardHtml = '<div class="card mb-3">';
            cardHtml += '<div class="card-body">';
            cardHtml += '<h5 class="card-title">' + discussion['topic'] + '</h5>';
            cardHtml += '<h6 class="card-subtitle mb-2 text-muted">By: ' + discussion['firstname'] + ' ' + discussion['lastname'] + '</h6>';
            cardHtml += '<p class="card-text">' + discussion['post'] + '</p>';
            cardHtml += '<p class="card-text"><small class="text-muted">Posted on: ' + discussion['created_at'] + '</small></p>'; // Display post timestamp
            cardHtml += '<button type="button" class="btn btn-warning" style="margin-bottom: 10px;" onclick="openContributeModal(' + discussion['postID'] + ', \'' + discussion['topic'] + '\')">Contribute</button>';
             
            // Display contributions within a nested card
            cardHtml += '<div class="card bg-light mb-3">';
            cardHtml += '<div class="card-body">';

            cardHtml += '<h6 class="card-subtitle mb-2 text-muted">Contributions</h6>';

            if (discussion['contributions'].length > 0) {
                discussion['contributions'].forEach(function (contribution) {
                    cardHtml += '<div class="card mb-2">';
                    cardHtml += '<div class="card-body">';
                    cardHtml += '<h6 class="card-subtitle mb-2 text-muted">By: ' + contribution['firstname'] + ' ' + contribution['lastname'] + '</h6>';
                    cardHtml += '<p class="card-text">' + contribution['content'] + '</p>';
                    cardHtml += '<p class="card-text"><small class="text-muted">Posted on: ' + contribution['timestamp'] + '</small></p>'; // Display contribution timestamp
                    cardHtml += '</div>';
                    cardHtml += '</div>';
                });
            } else {
                cardHtml += '<p>No contributions yet.</p>';
            }

            cardHtml += '</div>';
            cardHtml += '</div>'; // End of contributions card

            cardHtml += '</div>';
            cardHtml += '</div>'; // End of primary post card

            discussionsContainer.innerHTML += cardHtml;
        });
    } else {
        discussionsContainer.innerHTML = '<p>No discussions found for the selected course.</p>';
    }
}




// Function to open the "Contribute" modal
function openContributeModal(postId, topic) {
    var modalContent = '<div class="modal-body">';
    modalContent += '<p><strong>Topic:</strong> ' + topic + '</p>';
    modalContent += '<form id="contributeForm" action="process_contribution.php" method="post">';
    modalContent += '<div class="mb-3">';
    modalContent += '<label for="contributionContent" class="form-label">Contribution:</label>';
    modalContent += '<textarea class="form-control" name="contributionContent" id="contributionContent" rows="3" required></textarea>';
    modalContent += '</div>';
    modalContent += '<input type="hidden" name="postId" value="' + postId + '">';
    modalContent += '</form>';
    modalContent += '</div>';
    modalContent += '<div class="modal-footer">';
    modalContent += '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>';
    modalContent += '<button type="button" class="btn btn-primary" id="submitContributionBtn">Submit Contribution</button>';
    modalContent += '</div>';

    $('#contributeModal .modal-content').html(modalContent);

    $('#submitContributionBtn').on('click', function() {
        $('#contributeForm').submit();
    });
    $('#contributeModal').modal('show');
}

function submitContribution() {

$('#contributeModal').modal('hide');
 }

</script>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

