<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is an admin before proceeding
    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        include('db_connection.php');

        if (isset($_POST['deleteUserId'])) {
            // Delete operation
            $deleteUserId = $_POST['deleteUserId'];

            // Validate and sanitize input data 
            $deleteUserId = intval($deleteUserId);

            $delete_query = "DELETE FROM users WHERE userid = ?";

            $stmt = $conn->prepare($delete_query);
            $stmt->bind_param("i", $deleteUserId);

            $operation = 'delete';  
            if ($stmt->execute()) {
                $_SESSION['success_message'] = 'User ' . ucfirst($operation) . 'd successfully!';
            } else {
                $_SESSION['error_message'] = 'Error ' . $operation . 'ing user: ' . $stmt->error;
            }

         
        }

        // Check if userid is present, indicating an edit operation
        elseif (isset($_POST['userid'])) {
            // Edit operation
            $userid = $_POST['userid'];
            $role_id = $_POST['editRole'];
            $firstname = $_POST['editFirstName'];
            $lastname = $_POST['editLastName'];
            $email = $_POST['editEmail'];

            // Validate and sanitize input data 
            $userid = intval($userid);
            $role_id = intval($role_id);
            $firstname = mysqli_real_escape_string($conn, $firstname);
            $lastname = mysqli_real_escape_string($conn, $lastname);
            $email = mysqli_real_escape_string($conn, $email);

            $update_query = "UPDATE users 
                             SET role_id = ?, firstname = ?, lastname = ?, email = ? 
                             WHERE userid = ?";

            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("isssi", $role_id, $firstname, $lastname, $email, $userid);

            $operation = 'update';  
        } else {
            // Insert operation
            $role_id = $_POST['role'];
            $firstname = $_POST['firstName'];
            $lastname = $_POST['surname'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            // Validate and sanitize input data 
            $role_id = intval($role_id);
            $firstname = mysqli_real_escape_string($conn, $firstname);
            $lastname = mysqli_real_escape_string($conn, $lastname);
            $password = mysqli_real_escape_string($conn, $password);
            $email = mysqli_real_escape_string($conn, $email);

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert_query = "INSERT INTO users (role_id, firstname, lastname, password, datejoined, email, lastlogin) 
                             VALUES (?, ?, ?, ?, NOW(), ?, NULL)";

            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("issss", $role_id, $firstname, $lastname, $hashed_password, $email);

            $operation = 'insert';  
        }

        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'User ' . ucfirst($operation) . 'ed successfully!';
        } else {
            $_SESSION['error_message'] = 'Error ' . $operation . 'ing user: ' . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        // If the user is not an admin
        $_SESSION['error_message'] = 'You do not have permission to perform this operation.';
        header("Location: login.php");
    }

    // Redirect back to the admin page
    header("Location: admin.php?id=1");
}
?>
