<?php
session_start();
include('db_connection.php');

// Check if the session variable is set
if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];

    // Execute the SQL query
    $query = "SELECT s.assignmentID,
                     u.lastname,
                     g.grade,
                     g.comments,
                     s.assignmentID AS submissionID,
                     c.title AS courseTitle,
                     a.title AS assignmentTitle,
                     c.instructorid
              FROM submissions s
              JOIN grades g ON g.submissionID = s.submissionID
              JOIN users u ON u.userid = g.userID
              JOIN assignments a ON a.assignmentID = s.assignmentID
              JOIN course c ON c.courseid = a.courseID
              WHERE c.instructorid = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId); // Use the appropriate parameter type (i for integer, s for string, etc.)
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <title>Submission Details</title>
        </head>
        <body>
            <div class="container mt-4">
                <h2>Submission Details</h2>
                <table class="table table-striped mt-3">
                <thead style="font-size: 1em; background-color: #e67e22; color:white">
                        <tr>
                            <th>Last Name</th>
                            <th>Grade</th>
                            <th>Comments</th>
                            <th>Course Title</th>
                            <th>Assignment Title</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo $row['lastname']; ?></td>
                                <td><?php echo $row['grade']; ?></td>
                                <td><?php echo $row['comments']; ?></td>
                                <td><?php echo $row['courseTitle']; ?></td>
                                <td><?php echo $row['assignmentTitle']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div> 

            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
        </html>
        <?php
    } else {
        echo "No results found.";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "User ID not found in session.";
}

// Close the database connection
$conn->close();
?>
