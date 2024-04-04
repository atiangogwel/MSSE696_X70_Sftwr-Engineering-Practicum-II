<?php
include "FlashMessage.php";
include('db_connection.php');

$select_query = "SELECT users.*, roles.role_name 
                 FROM users 
                 INNER JOIN roles ON users.role_id = roles.role_id";

$result = $conn->query($select_query);
$users = [];

// Check if there are rows in the result set
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Close the database connection
$conn->close();
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>

<div class="container mt-4">
    <h2>User Management</h2>
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New</button>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Role Name</th>
                <th>firstname</th>
                <th>Last Name</th>
                <th>Date Joined</th>
                <th>Last Login</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['userid']; ?></td>
                    <td><?php echo $user['role_name']; ?></td>
                    <td><?php echo $user['firstname']; ?></td>
                    <td><?php echo $user['lastname']; ?></td>
                    <td><?php echo $user['datejoined']; ?></td>
                    <td><?php echo $user['lastlogin']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    
                    <td>
                        <!-- Button to trigger edit modal -->
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal<?php echo $user['userid']; ?>">
                            EDIT
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteUserModal<?php echo $user['userid']; ?>">
                        DELETE
                    </button>
                    </td>
                </tr>

                <!-- Bootstrap modal for edit user -->
                <div class="modal fade" id="editUserModal<?php echo $user['userid']; ?>" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="users_process.php" method="post">
                                    <input type="hidden" name="userid" value="<?php echo $user['userid']; ?>">

                                    <div class="mb-3">
                                        <label for="editRole" class="form-label">Role:</label>
                                        <select class="form-select" name="editRole" id="editRole" aria-label="Select Role" required>
    
                                            <option value="1">Admin</option>
                                            <option value="2">Student</option>
                                            <option value="3">Instructor</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editFirstName" class="form-label">First Name:</label>
                                        <input type="text" class="form-control" name="editFirstName" id="editFirstName" value="<?php echo $user['firstname']; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editLastName" class="form-label">Last Name:</label>
                                        <input type="text" class="form-control" name="editLastName" id="editLastName" value="<?php echo $user['lastname']; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editEmail" class="form-label">Email:</label>
                                        <input type="email" class="form-control" name="editEmail" id="editEmail" value="<?php echo $user['email']; ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Bootstrap modal for delete confirmation -->
            <div class="modal fade" id="deleteUserModal<?php echo $user['userid']; ?>" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this user?</p>
                            <form action="users_process.php" method="post">
                                <input type="hidden" name="deleteUserId" value="<?php echo $user['userid']; ?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>
            
            <?php if (empty($users)): ?>
                <tr><td colspan="8">No users found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap modal for add new user -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="users_process.php" method="post">
                    <div class="mb-3">
                        <label for="role" class="form-label">Role:</label>
                        <select class="form-select" name="role" id="role" aria-label="Select Role" required>
                            <option value="" selected disabled>Select Role</option>
                            <option value="1">Admin</option>
                            <option value="2">Student</option>
                            <option value="3">Instructor</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name:</label>
                        <input type="text" class="form-control" name="firstName" id="firstName" placeholder="Enter first name" required>
                    </div>
                    <div class="mb-3">
                        <label for="surname" class="form-label">Surname:</label>
                        <input type="text" class="form-control" name="surname" id="surname" placeholder="Enter surname" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password:</label>
                        <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
</body>
</html>

</body>
</html>
