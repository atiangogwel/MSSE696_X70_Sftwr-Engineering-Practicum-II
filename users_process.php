<?php
session_start();

class UserManagement {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function deleteUser($deleteUserId) {
        $deleteUserId = intval($deleteUserId);
        $delete_query = "DELETE FROM users WHERE userid = ?";
        $stmt = $this->conn->prepare($delete_query);
        $stmt->bind_param("i", $deleteUserId);
        return $stmt->execute();
    }

    public function updateUser($userid, $role_id, $firstname, $lastname, $email) {
        $userid = intval($userid);
        $role_id = intval($role_id);
        $firstname = mysqli_real_escape_string($this->conn, $firstname);
        $lastname = mysqli_real_escape_string($this->conn, $lastname);
        $email = mysqli_real_escape_string($this->conn, $email);
        $update_query = "UPDATE users 
                         SET role_id = ?, firstname = ?, lastname = ?, email = ? 
                         WHERE userid = ?";
        $stmt = $this->conn->prepare($update_query);
        $stmt->bind_param("isssi", $role_id, $firstname, $lastname, $email, $userid);
        return $stmt->execute();
    }

    public function insertUser($role_id, $firstname, $lastname, $password, $email) {
        $role_id = intval($role_id);
        $firstname = mysqli_real_escape_string($this->conn, $firstname);
        $lastname = mysqli_real_escape_string($this->conn, $lastname);
        $password = mysqli_real_escape_string($this->conn, $password);
        $email = mysqli_real_escape_string($this->conn, $email);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_query = "INSERT INTO users (role_id, firstname, lastname, password, datejoined, email, lastlogin) 
                         VALUES (?, ?, ?, ?, NOW(), ?, NULL)";
        $stmt = $this->conn->prepare($insert_query);
        $stmt->bind_param("issss", $role_id, $firstname, $lastname, $hashed_password, $email);
        return $stmt->execute();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is an admin before proceeding
    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        include('db_connection.php');
        $userManagement = new UserManagement($conn);

        if (isset($_POST['deleteUserId'])) {
            // Delete operation
            $deleteUserId = $_POST['deleteUserId'];
            $operation = 'delete';
            if ($userManagement->deleteUser($deleteUserId)) {
                $_SESSION['success_message'] = 'User ' . ucfirst($operation) . 'd successfully!';
            } else {
                $_SESSION['error_message'] = 'Error ' . $operation . 'ing user: ' . $conn->error;
            }
        } elseif (isset($_POST['userid'])) {
            // Edit operation
            $userid = $_POST['userid'];
            $role_id = $_POST['editRole'];
            $firstname = $_POST['editFirstName'];
            $lastname = $_POST['editLastName'];
            $email = $_POST['editEmail'];
            $operation = 'update';
            if ($userManagement->updateUser($userid, $role_id, $firstname, $lastname, $email)) {
                $_SESSION['success_message'] = 'User ' . ucfirst($operation) . 'd successfully!';
            } else {
                $_SESSION['error_message'] = 'Error ' . $operation . 'ing user: ' . $conn->error;
            }
        } else {
            // Insert operation
            $role_id = $_POST['role'];
            $firstname = $_POST['firstName'];
            $lastname = $_POST['surname'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $operation = 'insert';
            if ($userManagement->insertUser($role_id, $firstname, $lastname, $password, $email)) {
                $_SESSION['success_message'] = 'User ' . ucfirst($operation) . 'ed successfully!';
            } else {
                $_SESSION['error_message'] = 'Error ' . $operation . 'ing user: ' . $conn->error;
            }
        }

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
