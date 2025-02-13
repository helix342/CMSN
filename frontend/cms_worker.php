<?php
require "config.php";
include("session.php");
$worker_id = "civil";


// fetching worker details using department in session
$qry = "SELECT * FROM worker_details WHERE worker_id='$worker_id'";
$qry_run = mysqli_query($db, $qry);
$srow  = mysqli_fetch_array($qry_run);
$dept = $srow['worker_dept'];


$qry = "SELECT * FROM worker_details WHERE worker_id='$worker_id'";
$qry_run = mysqli_query($db, $qry);
$row  = mysqli_fetch_array($qry_run);

//New task query
$sql = "
    SELECT 
        cd.id,
        cd.faculty_id,
        faculty.name,
        faculty.dept,
        cd.block_venue,
        cd.venue_name,
        cd.type_of_problem,
        cd.problem_description,
        cd.images,
        cd.date_of_reg,
        cd.days_to_complete,
        cd.task_completion,
        cd.status,
        cd.feedback,
        m.task_id,
        m.priority
    FROM 
        complaints_detail AS cd
    JOIN 
        manager AS m ON cd.id = m.problem_id
    JOIN 
        faculty ON cd.faculty_id = faculty.id
    WHERE 
        (m.worker_dept='$dept')
    AND 
        cd.status = '9'
";

$stmt = $db->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$newcount = mysqli_num_rows($result);


//inprogress query
$sql1 = "
    SELECT 
        cd.id,
        cd.faculty_id,
        faculty.name,
        faculty.dept,
        cd.block_venue,
        cd.venue_name,
        cd.type_of_problem,
        cd.problem_description,
        cd.images,
        cd.date_of_reg,
        cd.days_to_complete,
        cd.task_completion,
        cd.status,
        cd.feedback,
        m.task_id,
        m.priority
    FROM 
        complaints_detail AS cd
    JOIN 
        manager AS m ON cd.id = m.problem_id
    JOIN 
        faculty ON cd.faculty_id = faculty.id
    WHERE 
        (m.worker_dept='$dept')
    AND 
        cd.status = '10'
";

$stmt = $db->prepare($sql1);
$stmt->execute();
$result1 = $stmt->get_result();
$progcount = mysqli_num_rows($result1);


//waiting for approval query
$sql2 = "
    SELECT 
        cd.id,
        cd.faculty_id,
        faculty.name,
        faculty.dept,
        cd.block_venue,
        cd.venue_name,
        cd.type_of_problem,
        cd.problem_description,
        cd.images,
        cd.date_of_reg,
        cd.days_to_complete,
        cd.task_completion,
        cd.status,
        cd.feedback,
        m.task_id,
        m.priority
    FROM 
        complaints_detail AS cd
    JOIN 
        manager AS m ON cd.id = m.problem_id
    JOIN 
        faculty ON cd.faculty_id = faculty.id
    WHERE 
        (m.worker_dept='$dept')
    AND 
        (cd.status = '11' OR cd.status = '18')
";

$stmt = $db->prepare($sql2);
$stmt->execute();
$result2 = $stmt->get_result();
$waitcount = mysqli_num_rows($result2);


//completed query
$sql3 = "
    SELECT 
        cd.id,
        cd.faculty_id,
        faculty.name,
        faculty.dept,
        cd.block_venue,
        cd.venue_name,
        cd.type_of_problem,
        cd.problem_description,
        cd.images,
        cd.date_of_reg,
        cd.days_to_complete,
        cd.task_completion,
        cd.status,
        cd.feedback,
        m.task_id,
        m.priority
    FROM 
        complaints_detail AS cd
    JOIN 
        manager AS m ON cd.id = m.problem_id
    JOIN 
        faculty ON cd.faculty_id = faculty.id
    WHERE 
        (m.worker_dept='$dept')
    AND 
        cd.status = '16'
";

$stmt = $db->prepare($sql3);
$stmt->execute();
$result3 = $stmt->get_result();
$compcount = mysqli_num_rows($result3);


//not approved query
$sql4 = "
    SELECT 
        cd.id,
        cd.faculty_id,
        faculty.name,
        faculty.dept,
        cd.block_venue,
        cd.venue_name,
        cd.type_of_problem,
        cd.problem_description,
        cd.images,
        cd.date_of_reg,
        cd.days_to_complete,
        cd.task_completion,
        cd.status,
        cd.feedback,
        m.task_id,
        m.priority
    FROM 
        complaints_detail AS cd
    JOIN 
        manager AS m ON cd.id = m.problem_id
    JOIN 
        faculty ON cd.faculty_id = faculty.id
    WHERE 
        (m.worker_dept='$dept')
    AND 
        cd.status = '15'
";


$stmt = $db->prepare($sql4);
$stmt->execute();
$result4 = $stmt->get_result();
$notcount = mysqli_num_rows($result4);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Management System</title>
    <link rel="icon" type="image/png" sizes="32x32" href="image/icons/mkce_s.png">
    <link rel=stylesheet href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/font.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
    body {
        font-family: 'Rubik';
    }
    </style>
</head>

<body>
    <!-- Sidebar -->

    <div class="mobile-overlay" id="mobileOverlay"></div>
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <img src="image/mkce.png" alt="College Logo">
            <img class='s_logo' src="image/mkce_s.png" alt="College Logo">
        </div>

        <div class="menu">
            <a href="cms_worker.php" class="menu-item active">
                <i class="fas fa-home text-primary"></i>
                <span>Dashboard</span>
            </a>
            <!-- <a href="" class="menu-item">
                <i class="fa-solid fa-user-secret text-white"></i>
                <span>Admin</span>
            </a> -->
            <a href="cms_worknew.php" class="menu-item">
                <i class="fa-solid fa-users text-info"></i>
                <span>Assign Work</span>
            </a>
            <a href="cms_workall.php" class="menu-item">
                <i class="fa-solid fa-address-book text-success"></i>
                <span><?php echo $worker_id?></span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">

        <!-- <div class="loader-container" id="loaderContainer">
            <div class="loader"></div>
        </div> -->

        <!-- Topbar -->
        <div class="topbar">
            <div class="hamburger" id="hamburger">
                <i class="fas fa-bars"></i>
            </div>
            <div class="user-profile">
                <div class="user-menu" id="userMenu">
                    <div class="user-avatar">
                        <img src="/api/placeholder/35/35" alt="User">
                        <div class="online-indicator"></div>
                    </div>
                    <div class="dropdown-menu">
                        <!-- <a class="dropdown-item">
                            <i class="fa-solid fa-user-plus"></i>
                            &nbsp;&nbsp;Add User
                        </a> -->
                        <a class="dropdown-item">
                            <i class="fas fa-key"></i>
                            &nbsp;&nbsp;Change Password
                        </a>
                        <a class="dropdown-item">
                            <i class="fas fa-sign-out-alt"></i>
                            &nbsp;&nbsp;Logout
                        </a>
                    </div>
                </div>
                <span><?php echo $row['worker_first_name'] ?></span>
            </div>
        </div>

        <!-- Breadcrumb -->
        <div class="breadcrumb-area">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Complaint Management System</li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="">Worker</a>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="container-fluid">
            <div class="row">
                <!-- Column -->
                <div class="col-md-6 col-lg-4 col-xlg-3">
                    <div class="card card-hover">
                        <div class="box bg-danger text-center">
                            <h1 class="font-light text-white">
                                <i class="fa-solid fa-user"></i>
                            </h1>
                            <h6 class="text-white">
                                Worker Head Name
                            </h6>
                            <h5 class="text-white" id="workerName"><?php echo $row['worker_first_name'] ?></h5>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <div class="col-md-6 col-lg-4 col-xlg-3">
                    <div class="card card-hover">
                        <div class="box bg-success text-center">
                            <h1 class="font-light text-white">
                                <i class="fa-solid fa-hard-hat"></i>
                            </h1>
                            <h6 class="text-white">
                                Worker department
                            </h6>
                            <h5 class="text-white" id="employmentType"><?php echo $row['worker_dept'] ?></h5>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <div class="col-md-6 col-lg-4 col-xlg-3">
                    <div class="card card-hover">
                        <div class="box bg-primary text-center">
                            <h1 class="font-light text-white">
                                <i class="fa-solid fa-briefcase"></i>
                            </h1>
                            <h6 class="text-white">
                                Designation
                            </h6>
                            <h5 id="workerdepartment" class="text-white">Worker-Head</h5>
                        </div>
                    </div>
                </div>
                <!-- Column -->
            </div><br><br>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Complaint Management System</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- In Progress -->
                                <div class="col-12 col-md-3" style="margin-bottom: 40px">
                                    <div class="cir">
                                        <div class="bo">
                                            <div class="content1">
                                                <div class="stats-box text-center p-3" style="background-color:orange;">
                                                    <i class="fas fa-spinner"></i>
                                                    <h1 class="font-light text-white"><?php echo $progcount; ?></h1>
                                                    <small class="font-light">In Progress</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Waiting for Approval -->
                                <div class="col-12 col-md-3">
                                    <div class="cir">
                                        <div class="bo">
                                            <div class="content1">
                                                <div class="stats-box text-center p-3"
                                                    style="background-color:rgb(14, 86, 239);">
                                                    <i class="fas fa-hourglass-half"></i>
                                                    <h1 class="font-light text-white"><?php echo $waitcount ?></h1>
                                                    <small class="font-light">Waiting for Approval</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Not Approved -->
                                <div class="col-12 col-md-3">
                                    <div class="cir">
                                        <div class="bo">
                                            <div class="content1">
                                                <div class="stats-box text-center p-3" style="background-color:red;">
                                                    <i class="fas fa-times-circle"></i>
                                                    <h1 class="font-light text-white"><?php echo $newcount ?></h1>
                                                    <small class="font-light">New task</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Completed -->
                                <div class="col-12 col-md-3">
                                    <div class="cir">
                                        <div class="bo">
                                            <div class="content1">
                                                <div class="stats-box text-center p-3"
                                                    style="background-color:rgb(70, 160, 70);">
                                                    <i class="fas fa-check-circle"></i>
                                                    <h1 class="font-light text-white"><?php echo $compcount ?></h1>
                                                    <small class="font-light">Completed</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Footer -->
        <footer class="footer">
            <div class="footer-copyright" style="text-align: center;">
                <p>Copyright © 2024 Designed by <span style="background: linear-gradient(to right, #cb2d3e, #ef473a);"
                        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip:
                        text;">Technology
                        Innovation Hub - MKCE. </span>All rights reserved.</p>
            </div>
        </footer>
    </div>

    <script src="assets/script/bootstrap.js"></script>
    <script src="assets/script/script.js"></script>
</body>

</html>