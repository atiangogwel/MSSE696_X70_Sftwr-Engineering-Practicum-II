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
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>EduHubConnect</title>
        <link href="css/panel.css" rel="stylesheet" />
    </head>
    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-dark" style="background-color: #008080; color: #ffffff;"  id="sidebar-wrapper">
                <div class="sidebar-heading border-bottom text-white" style="font-size: 1em; background-color: #008080;">EduHubConnect, Student</div>
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action  text-white p-3"  style="font-size: 1em; background-color: #008080;" href="#!">Dashboard</a>
                    <a class="list-group-item list-group-item-action text-white p-3"  style="font-size: 1em; background-color: #008080;" href="student_dashboard.php?id=1">Courses</a>
                    <a class="list-group-item list-group-item-action text-white p-3"  style="font-size: 1em; background-color: #008080;" href="student_dashboard.php?id=3">Assignments</a>
                    <a class="list-group-item list-group-item-action text-white p-3"  style="font-size: 1em; background-color: #008080;" href="student_dashboard.php?id=2">Grades</a>
                    <a class="list-group-item list-group-item-action text-white p-3"  style="font-size: 1em; background-color: #008080;" href="student_dashboard.php?id=4">Discussions</a>
                    <a class="list-group-item list-group-item-action text-white p-3"  style="font-size: 1em; background-color: #008080;"  href="logout.php">Logout</a>

                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                <!-- Top navigation-->
                <nav class="navbar navbar-light" style="background-color: #008080; color: #ffffff;">
                    <div class="container-fluid">
                        <button style="background-color: #008080; color: #ffffff;" id="sidebarToggle">Hide/Show Menu</button>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                                <li class="nav-item active"><a class="nav-link" href="#!">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="#!">Link</a></li>

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
                            include 'myCourses.php';
                        }
                        elseif($page_id==2){
                            include 'student_grades.php';
    
                        }
                        elseif($page_id==3){
                            include 'student_assignments.php';
                            //
                        }
                        elseif($page_id==4){
                            include 'student_discussions.php';
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
