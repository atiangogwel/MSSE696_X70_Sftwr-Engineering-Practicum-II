<!DOCTYPE html>
<html lang="en">
<head>
    <title>Submissions</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <?php
        session_start();
        include "db_connection.php";

        function fetchSubmissions($assignmentId, $conn) {
            $selectSubmissionsQuery = "
                SELECT s.*, u.lastname, u.firstname, g.grade
                FROM submissions s
                JOIN users u ON s.userID = u.userid
                LEFT JOIN grades g ON s.submissionID = g.submissionID
                WHERE s.assignmentID = ?";
            
            $stmt = $conn->prepare($selectSubmissionsQuery);
            $stmt->bind_param("i", $assignmentId);
            $stmt->execute();
            $result = $stmt->get_result();
        
            $submissions = [];
        
            // Fetch submissions
            while ($submission = $result->fetch_assoc()) {
                $submission['graded'] = !empty($submission['grade']); // Check if submission has a grade
                $submissions[] = $submission;
            }
        
            $stmt->close();
            return $submissions;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assignmentId'])) {
            $assignmentId = $_POST['assignmentId'];
            $submissions = fetchSubmissions($assignmentId, $conn);
        } elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['download'])) {
            $submissionId = $_GET['download'];

            $selectSubmissionQuery = "SELECT submissionFile FROM submissions WHERE submissionID = ?";
            $stmt = $conn->prepare($selectSubmissionQuery);
            $stmt->bind_param("i", $submissionId);
            $stmt->execute();
            $stmt->bind_result($submissionFile);
            $stmt->fetch();
            $stmt->close();

            // Set the appropriate headers for file download
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($submissionFile) . '"');
            header('Content-Length: ' . filesize($submissionFile));

            // Output the file
            readfile($submissionFile);

            $conn->close();
            exit(); // Terminate the script after file download
        } 
        
        
        else {
            // Handle invalid or missing parameters
            echo 'Invalid request.';
            exit();
        }
        
        ?>

        
<?php if (isset($submissions) && count($submissions) > 0): ?>
    <h3 class="mb-3">Submissions for the selected assignment:</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student</th>
                <th>Submission Date</th>
                <th>Attempt</th>
                <th>Submission File</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($submissions as $submission): ?>
                <tr>
                    <td><?php echo $submission['lastname'] . ', ' . $submission['firstname']; ?></td>
                    <td><?php echo $submission['submissionAttempt']; ?></td>
                    <td><?php echo $submission['submissionDate']; ?></td>
                    <td>
                        <a href="getSubmissions.php?download=<?php echo $submission['submissionID']; ?>" class="btn btn-primary">Download</a>
                    </td>
                    <td>
                        <?php if ($submission['graded']): ?>
                            <!-- Display "Graded" button if already graded -->
                            <button class="btn btn-secondary" disabled>Graded</button>
                            <button type="button" class="btn btn-primary editBtn" data-toggle="modal" data-target="#editGradeModal<?php echo $submission['submissionID']; ?>">
                                Edit Grade
                            </button>
                        <?php else: ?>
                            <!-- Display "Grade" button if not graded -->
                            <button type="button" class="btn btn-success gradeBtn" data-toggle="modal" data-target="#gradeModal<?php echo $submission['submissionID']; ?>">
                                Grade
                            </button>
                        <?php endif; ?>                        

                        <input type="hidden" class="submissionID" value="<?php echo $submission['submissionID']; ?>">
                        <input type="hidden" class="firstname" value="<?php echo $submission['firstname']; ?>">
                        <input type="hidden" class="lastname" value="<?php echo $submission['lastname']; ?>">
                        <input type="hidden" class="submissionDate" value="<?php echo $submission['submissionDate']; ?>">
                        <input type="hidden" class="userID" value="<?php echo $submission['userID']; ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No submissions found for the selected assignment.</p>
<?php endif; ?>
    </div>

    <!-- Grade Modal -->
    <div class="modal fade" id="gradeModal" tabindex="-1" role="dialog" aria-labelledby="gradeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gradeModalLabel">Grade Submission</h5>
            </div>
          
            
            <div class="modal-body">
                <form action="processGrade.php" method="post">
                    <input type="hidden" id="submissionId" name="submissionId">
                    <div class="form-group">
                        <label for="grade">Grade:</label>
                        <select class="form-control" id="grade" name="grade" required>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="comments">Comments:</label>
                        <textarea class="form-control" id="comments" name="comments" rows="3" required></textarea>
                    </div>
                    <input type="hidden" name="studentID" value="<?php echo $submission['userID']; ?>">
                    <button type="submit" class="btn btn-primary">Submit Grade</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cancelGrade()">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Grade Modal -->
<div class="modal fade" id="editGradeModal" tabindex="-1" role="dialog" aria-labelledby="editGradeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGradeModalLabel">Edit Grade</h5>
            </div>
            <div class="modal-body">
                <form action="processEditGrade.php" method="post">
                    <input type="hidden" id="editSubmissionId" name="editSubmissionId">
                    <div class="form-group">
                        <label for="editGrade">Grade:</label>
                        <select class="form-control" id="editGrade" name="editGrade" required>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editComments">Comments:</label>
                        <textarea class="form-control" id="editComments" name="editComments" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Grade</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeEditModal()">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        // Event listener for the Edit Grade button
        $('.editBtn').click(function () {
            // Get submission details from hidden inputs
            var submissionID = $(this).siblings('.submissionID').val();
            var firstname = $(this).siblings('.firstname').val();
            var lastname = $(this).siblings('.lastname').val();
            var submissionDate = $(this).siblings('.submissionDate').val();

            // Set values in the edit modal
            $('#editSubmissionId').val(submissionID);
            $('#editGradeModalLabel').html('Edit Grade - ' + lastname + ', ' + firstname + ' (' + submissionDate + ')');

            // Fetch comments and grade from the server using AJAX
            $.ajax({
            type: "POST",
            url: "processEditGrade.php",  
            data: { submissionId: submissionID },
            dataType: "json",
            success: function (data) {
                // Send the fetched data to a PHP file
                $.ajax({
                    type: "POST",
                    url: "processEditGrade.php",
                    data: { fetchedData: data },
                    success: function (response) {
                    },
                });

                // Populate the inputs with fetched data
                $('#editGrade').val(data.grade);
                $('#editComments').val(data.comments);

                // Show the edit modal
                $('#editGradeModal').modal('show');
            },
            error: function () {
                // Handle errors if needed
                alert('Error fetching submission details.');
            }
        });
    });

        // Event listener for the Grade button
        $('.gradeBtn').click(function () {
            // Get submission details from hidden inputs
            var submissionID = $(this).siblings('.submissionID').val();
            var firstname = $(this).siblings('.firstname').val();
            var lastname = $(this).siblings('.lastname').val();
            var studentID  = $(this).siblings('.studentID').val();
            var submissionDate = $(this).siblings('.submissionDate').val();

            // Set values in the modal
            $('#submissionId').val(submissionID);
            $('#gradeModalLabel').html('Grade Submission - ' + firstname + ', ' + firstname + ' (' + submissionDate + ')');

            // Show the modal
            $('#gradeModal').modal('show');
        });
    });
    function cancelGrade() {
            $('#gradeModal').modal('hide');
        }

        function closeEditModal() {
            $('#editGradeModal').modal('hide');
        }
</script>

