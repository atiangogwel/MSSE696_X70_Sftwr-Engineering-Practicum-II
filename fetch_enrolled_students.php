<?php
include('db_connection.php'); 

$courseId = $_GET['courseId'] ?? 0; 

// SQL to fetch enrolled students
$sql = "SELECT u.userid, u.firstname, u.lastname FROM enrollments e JOIN users u ON e.userID = u.userid WHERE e.courseID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $courseId);
$stmt->execute();
$result = $stmt->get_result();

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

// Close connections if necessary
$stmt->close();
$conn->close();

echo json_encode($students); // Return the list of students as JSON
?>