<?php
session_start();

class Login {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function authenticate($email, $password) {
        // Perform SQL query to check if the email matches and retrieve hashed password and role
        $query = "
            SELECT userid, password, role_name FROM users
            INNER JOIN roles ON users.role_id = roles.role_id
            WHERE email = ?;
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Fetch the result
        $row = $result->fetch_assoc();
        
        if ($row) {
            // If the user is found
            $stored_password = $row['password'];
    
            // Verify the password
            if (password_verify($password, $stored_password)) {
                // Update last login time
                $this->updateLastLogin($email);

                // Store user information in session
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $row['role_name'];
                $_SESSION['userid'] = $row['userid']; // Store userid in session
    
                // Redirect the user
                if ($row['role_name'] == 'student') {
                    header("Location: student_dashboard.php?id=2");
                    exit();
                } elseif ($row['role_name'] == 'admin') {
                    $_SESSION['admin'] = true; // admin status
                    header("Location: admin.php?id=1");
                    exit();
                } elseif ($row['role_name'] == 'instructor') {
                    header("Location: instructor_dashboard.php?id=1");
                    exit();
                }
            } else {
                return "Invalid email or password.";
            }
        } else {
            return "Invalid email or password.";
        }
    }

    public function updateLastLogin($email) {
        // Update last login time
        $update_query = "UPDATE users SET lastlogin = NOW() WHERE email = ?";
        $update_stmt = $this->conn->prepare($update_query);
        $update_stmt->bind_param("s", $email);
        $update_stmt->execute();
        $update_stmt->close();
    }
}




// Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include('db_connection.php');

        // Get email and password from the form
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Initialize the Login class
        $Login = new Login($conn);

        // Authenticate the user
        $errorMessage = $Login->authenticate($email, $password);

        // Close the database connection
        $conn->close();
}
?>







<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div id="errorMessage" class="text-danger mb-3"><?php if(isset($errorMessage)) echo $errorMessage; ?></div>
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Login</h2>

                    <!-- Login form -->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
