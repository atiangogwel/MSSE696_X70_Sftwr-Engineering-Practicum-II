<?php
session_start();
//navigation
$page_id = 0;
if(isset($_GET['id']))
{
    $page_id = $_GET['id'];
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>EduHubConnect</title>
        <link href="css/panel.css" rel="stylesheet" />
    </head>
    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-dark" id="sidebar-wrapper">
                <div class="sidebar-heading border-bottom bg-dark text-white" style="font-size: 1em;">EduHubConnect, Admin</div>
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action bg-dark text-white p-3" href="#!">Dashboard</a>
                    <a class="list-group-item list-group-item-action bg-dark text-white p-3" href="admin.php?id=1">Users</a>
                    <a class="list-group-item list-group-item-action bg-dark text-white p-3" href="logout.php">Logout</a>
                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom" style="color: white;">
                    <div class="container-fluid">
                        <button class="btn btn-primary" id="sidebarToggle">Hide/Show Menu</button>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                                <li class="nav-item active"><a class="nav-link" href="#!">Home</a></li>
 
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- Page content-->
                <div class="container-fluid">
                <div id="content-container"></div>
                <?php
                    
                    if($page_id ==1)
                    {
                        include 'manage_users.php';
                    }
                    ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/panel.js"></script>
        <script src="js/navigation.js"></script>
        <script src="js/logout.js"></script>
        <script>
            // Call loadSavedContent when the page loads
            window.addEventListener('load', loadSavedContent);
        </script>
    </body>
</html>
