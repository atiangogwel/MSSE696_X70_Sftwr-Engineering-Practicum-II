<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection code (assuming you have already included db_connection.php)
    include('db_connection.php');

    // Get email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Perform SQL query to check if the email matches and retrieve hashed password and role
    $query = "SELECT * FROM users 
              INNER JOIN roles ON users.role_id = roles.role_id
              WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // If the user is found
        $user = $result->fetch_assoc();

        // Verify the entered password against the hashed password in the database
        if (password_verify($password, $user['password'])) {
            // If the password is correct

            // Update lastlogin in the database
            $updateLastLoginQuery = "UPDATE users SET lastlogin = NOW() WHERE userid = ?";
            $stmtUpdate = $conn->prepare($updateLastLoginQuery);
            $stmtUpdate->bind_param("i", $user['userid']);
            $stmtUpdate->execute();
            $stmtUpdate->close();

            // Store user information in session
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $user['role_name'];
            $_SESSION['userid'] = $user['userid']; // Store userid in session

            // Redirect the user
            if ($user['role_name'] == 'student') {
                header("Location: student_dashboard.php?id=2");
                exit();

            } elseif ($user['role_name'] == 'admin') {
                $_SESSION['admin'] = true; // admin status
                header("Location: admin.php?id=1");
                exit();
                
            } elseif ($user['role_name'] == 'instructor') {
                header("Location: instructor_dashboard.php?id=1");
                exit();
            }
        } else {
            // If the password is incorrect, display an error message
            $errorMessage = "Invalid email or password.";
        }
    } else {
        // If the user is not found, display an error message
        $errorMessage = "Invalid email or password.";
    }

    // Close the statement and the database connection
    $stmt->close();
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
