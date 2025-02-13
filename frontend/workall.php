<?php
require "config.php";


$worker_id = "civil";


//fetching worker head details using session v ar
$qry = "SELECT * FROM worker_details WHERE worker_id='$worker_id'";
$qry_run = mysqli_query($db, $qry);
$srow  = mysqli_fetch_array($qry_run);
$dept = $srow['worker_dept'];









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
        cd.extend_date,
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
        cd.reason,
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
        cd.date_of_completion,
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
        cd.status IN('14','16')
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
    <title>Complaints Management System</title>
    <link rel="icon" type="image/png" sizes="32x32" href="image/icons/mkce_s.png">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/tabs.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/datatable.css">
    <link rel="stylesheet" href="assets/css/font.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
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
            <a href="windex.php" class="menu-item ">
                <i class="fas fa-home text-primary"></i>
                <span>Dashboard</span>
            </a>
            <!-- <a href="" class="menu-item">
                <i class="fa-solid fa-user-secret text-white"></i>
                <span>Admin</span>
            </a> -->
            <a href="new_work.php" class="menu-item ">
                <i class="fa-solid fa-users text-info"></i>
                <span>Work Asign</span>
            </a>
            <a href="workall.php" class="menu-item active">
            <i class="fa-solid fa-address-book text-success"></i>
                <span><?php echo $worker_id; ?></span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">

        <div class="loader-container" id="loaderContainer">
            <div class="loader"></div>
        </div>

        <!-- Topbar -->
        <div class="topbar">
            <div class="hamburger" id="hamburger">
                <i class="fas fa-bars"></i>
            </div>
            <!-- <div class="brand-logo">
                <i class="fas fa-chart-line"></i>
                MIC
            </div> -->
            <div class="user-profile">
                <div class="user-menu" id="userMenu">
                    <div class="user-avatar">
                        <img src="/api/placeholder/35/35" alt="User">
                        <div class="online-indicator"></div>
                    </div>
                    <div class="dropdown-menu">
                        <a class="dropdown-item">
                            <i class="fas fa-key"></i>
                            Change Password
                        </a>
                        <a class="dropdown-item">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </a>
                    </div>
                </div>
                <span><?php echo $srow['worker_first_name'] ?></span>
            </div>
        </div>

        <!-- Breadcrumb -->
        <div class="breadcrumb-area">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $srow['worker_dept']; ?></li>
                </ol>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="container-fluid">
            <div class="container">
                <div class="custom-tabs">
                    <!-- Navigation Tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <!-- Tab 1: In Progress -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="add-bus-tab" data-bs-toggle="tab"
                                data-bs-target="#inprogressdiv" type="button" role="tab">
                                <i class="fas fa-spinner tab-icon"></i> In Progress(<?php echo $progcount ?>)
                            </button>
                        </li>

                        <!-- Tab 2: Waiting For Approval -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="edit-bus-tab" data-bs-toggle="tab"
                                data-bs-target="#waitingforapproval" type="button" role="tab">
                                <i class="fas fa-hourglass-half tab-icon"></i> Waiting For Approval (<?php echo $waitcount ?>)
                            </button>
                        </li>

                        <!-- Tab 3: Not Approved -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="delete-bus-tab" data-bs-toggle="tab"
                                data-bs-target="#notapproved" type="button" role="tab">
                                <i class="fas fa-times-circle tab-icon"></i> Not Approved (<?php echo $notcount ?>)
                            </button>
                        </li>

                        <!-- Tab 4: Completed -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="view-bus-tab" data-bs-toggle="tab" data-bs-target="#completed"
                                type="button" role="tab">
                                <i class="fas fa-check-circle tab-icon"></i> Completed (<?php echo $compcount ?>)
                            </button>
                        </li>
                    </ul>
                    <!-- Tab Content -->
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="inprogressdiv" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="mb-0">Complaint Management System</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="complaint_table"
                                                    class="table table-striped table-bordered custom-table">
                                                    <thead
                                                        class="table-class">
                                                        <tr class="gradient-header">

                                                            <th class="text-center">
                                                                S.No
                                                            </th>
                                                            <th class="col-md-2 text-center">
                                                                Complaint Date
                                                            </th>
                                                            <th class="text-center">
                                                                Task ID
                                                            </th>
                                                            <th class="text-center col-md-2">
                                                                Dept
                                                            </th>
                                                            <th class="col-md-2 text-center">
                                                                Complaint
                                                            </th>
                                                            <th class="text-center">
                                                                Priority
                                                            </th>
                                                            <th class="text-center">

                                                                Photos

                                                            </th>
                                                            <th class="text-center">
                                                                Deadline
                                                            </th>
                                                            <th class="text-center">
                                                                Status
                                                            </th>
                                                            <th class="text-center">
                                                                Action
                                                            </th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id="progbody">
                                                                        <?php
                                                                        $count = 1;
                                                                        while ($row = $result1->fetch_assoc()) {
                                                                            if($row['extend_date']==1){
                                                                                echo "<tr style='background-color:      #c2f0c2
'>";

                                                                            }
                                                                            else{
                                                                            echo "<tr>";
                                                                            }
                                                                            
                                                                            echo "<td class='text-center'>" . $count++ . "</td>";
                                                                            echo "<td class='text-center'>" . htmlspecialchars($row['date_of_reg']) . "</td>";
                                                                            echo "<td class='text-center'>" . htmlspecialchars($row['task_id']) . "</td>";
                                                                            echo "<td class='text-center'>" . htmlspecialchars($row['dept']) . "</td>";
                                                                        ?>
                                                                            <td class='text-center'>
                                                                                <button type='button' class='btn btn margin-5 view-complaint
                                                            '
                                                                                    data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                                    <i class="fas fa-eye" style="font-size: 25px;"></i>

                                                                                </button>
                                                                            </td>
                                                                            <?php
                                                                            echo "<td class='text-center'>" . htmlspecialchars($row['priority']) . "</td>";
                                                                            ?>
                                                                            <td class='text-center'>
                                                                                <button type='button' class='btn margin-5 showbeforeimg'
                                                                                    data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                                    <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                                </button>
                                                                            </td>
                                                                            <?php
                                                                            echo "<td class='text-center'>" . htmlspecialchars($row['days_to_complete']) . "</td>";
                                                                            echo "<td class='text-center'>In Progress</td>";
                                                                            ?>
                                                                            <td class='text-center'>
                                                                                <button type='button' class='work-comp btn btn-primary margin-5' data-value="<?php echo $srow['worker_dept'] ?>"
                                                                                    data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                                    Work Completion
                                                                                </button>
                                                                            </td>
                                                                        <?php echo "</tr>";
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="waitingforapproval" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="mb-0">Complaint Management System</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="waitingapproval_table"
                                                    class="table table-striped table-bordered custom-table">
                                                    <thead
                                                        class="table-class">
                                                        <tr class="gradient-header">

                                                            <th class="text-center">
                                                                S.No
                                                            </th>
                                                            <th class="col-md-2 text-center">
                                                                Complaint Date
                                                            </th>
                                                            <th class="text-center">
                                                                Task ID
                                                            </th>
                                                            <th class="text-center">
                                                                Dept
                                                            </th>
                                                            <th class="col-md-2 text-center">
                                                                Complaint
                                                            </th>
                                                            <th class="text-center">
                                                                Priority
                                                            </th>
                                                            <th class="text-center col-md-2">

                                                                Photos

                                                            </th>
                                                            <th class=" col-md-2 text-center">
                                                                Deadline
                                                            </th>
                                                            <th class=" col-md-2 text-center">
                                                                Reason
                                                            </th>
                                                            <th class="text-center">
                                                                Task Completion
                                                            </th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                            <?php
                                                            $count = 1;
                                                            while ($row = $result2->fetch_assoc()) {
                                                                echo "<tr>";
                                                                echo "<td class='text-center'>" . $count++ . "</td>";
                                                                echo "<td class='text-center'>" . htmlspecialchars($row['date_of_reg']) . "</td>";
                                                                echo "<td class='text-center'>" . htmlspecialchars($row['task_id']) . "</td>";
                                                                echo "<td class='text-center'>" . htmlspecialchars($row['dept']) . "</td>";
                                                            ?>
                                                                <td class='text-center'>
                                                                    <button type='button' class='btn btn margin-5 view-complaint
                                                            '
                                                                        data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                        <i class="fas fa-eye" style="font-size: 25px;"></i>

                                                                    </button>
                                                                </td>
                                                                <?php
                                                                echo "<td class='text-center'>" . htmlspecialchars($row['priority']) . "</td>";
                                                                ?>
                                                                <td>
                                                                    <div class="d-flex justify-content-between">
                                                                        <!-- Align the first button to the left -->

                                                                        <button type='button' class='btn margin-5 showbeforeimg'
                                                                            data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                            <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                        </button>

                                                                        <!-- Align the second button to the right -->
                                                                        <button type="button" class="btn I"
                                                                            style="margin-left:-12px;" data-toggle="modal"
                                                                            data-target="#Modal4" data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                            <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            <?php
                                                                echo "<td class='text-center'>" . htmlspecialchars($row['days_to_complete']) . "</td>";
                                                                echo "<td class='text-center'>" . htmlspecialchars($row['reason']) . "</td>";
                                                                echo "<td class='text-center'>" . htmlspecialchars($row['task_completion']) . "</td>";
                                                                echo "</tr>";
                                                            }
                                                            ?>
                                                        </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="notapproved" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="mb-0">Complaint Management System</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="notapproved_table"
                                                    class="table table-striped table-bordered custom-table">
                                                    <thead
                                                        class="table-class">
                                                        <tr class="gradient-header">

                                                            <th class="text-center">
                                                                S.No
                                                            </th>
                                                            <th class="col-md-2 text-center">
                                                                Complaint Date
                                                            </th>
                                                            <th class="text-center">
                                                                Task ID
                                                            </th>
                                                            <th class="text-center col-md-2">
                                                                Dept
                                                            </th>
                                                            <th class="col-md-2 text-center">
                                                                Complaint
                                                            </th>
                                                            <th class="text-center">
                                                                Priority
                                                            </th>
                                                            <th class="text-center">

                                                                Photos

                                                            </th>
                                                            <th class="text-center">
                                                                Deadline
                                                            </th>
                                                            <th class="text-center">
                                                                Comments
                                                            </th>
                                                            <th class="text-center">
                                                                Status
                                                            </th>
                                                            <th class="text-center">
                                                                Action
                                                            </th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                                        <?php
                                                                        $count = 1;
                                                                        while ($row = $result4->fetch_assoc()) {
                                                                            echo "<tr>";
                                                                            echo "<td class='text-center'>" . $count++ . "</td>";
                                                                            echo "<td class='text-center'>" . htmlspecialchars($row['date_of_reg']) . "</td>";
                                                                            echo "<td class='text-center'>" . htmlspecialchars($row['task_id']) . "</td>";
                                                                            echo "<td class='text-center'>" . htmlspecialchars($row['dept']) . "</td>";
                                                                        ?>
                                                                            <td class='text-center'>
                                                                                <button type='button' class='btn btn margin-5 view-complaint
                                                            '
                                                                                    data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                                    <i class="fas fa-eye" style="font-size: 25px;"></i>
                                                                                </button>
                                                                            </td>
                                                                            <?php
                                                                            echo "<td class='text-center'>" . htmlspecialchars($row['priority']) . "</td>";
                                                                            ?>
                                                                            <td class='text-center'>
                                                                                <button type='button' class='btn  margin-5 showbeforeimg'
                                                                                    data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                                    <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                                </button>
                                                                            </td>
                                                                            <?php
                                                                            echo "<td class='text-center'>" . htmlspecialchars($row['days_to_complete']) . "</td>";
                                                                            echo "<td class='text-center'>" . htmlspecialchars($row['feedback']) . "</td>";
                                                                            echo "<td class='text-center'>Pending</td>";
                                                                            ?>
                                                                            <td class='text-center'>
                                                                                <button type='button' class='btn btn-primary margin-5 start-work-btn '
                                                                                    data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                                    Start to work
                                                                                </button>
                                                                            </td>
                                                                        <?php echo "</tr>";
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="completed" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="mb-0">Complaint Management System</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="completed_table"
                                                    class="table table-striped table-bordered custom-table">
                                                    <thead
                                                        class="table-class">
                                                        <tr class="gradient-header">
                                                            <th class="text-center">
                                                                S.No
                                                            </th>
                                                            <th class="col-md-2 text-center">
                                                                Complaint Date
                                                            </th>
                                                            <th class="text-center">
                                                                Task ID
                                                            </th>
                                                            <th class="text-center">
                                                                Dept
                                                            </th>
                                                            <th class="col-md-2 text-center">
                                                                Complaint
                                                            </th>
                                                            <th class="text-center">

                                                                Photos

                                                            </th>
                                                            <th class=" col-md-2 text-center">
                                                                Deadline</h5>
                                                            </th>
                                                            <th class=" col-md-2 text-center">
                                                                Date of completion
                                                            </th>
                                                            <th class="text-center">
                                                                Status
                                                            </th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                            <?php
                                                            $count = 1;
                                                            while ($row = $result3->fetch_assoc()) {
                                                                echo "<tr>";
                                                                echo "<td class='text-center'>" . $count++ . "</td>";
                                                                echo "<td class='text-center'>" . htmlspecialchars($row['date_of_reg']) . "</td>";
                                                                echo "<td class='text-center'>" . htmlspecialchars($row['task_id']) . "</td>";
                                                                echo "<td class='text-center'>" . htmlspecialchars($row['dept']) . "</td>";
                                                            ?>
                                                                <td class='text-center'>
                                                                    <button type='button' class='btn btn margin-5 view-complaint
                                                            '
                                                                        data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                        <i class="fas fa-eye" style="font-size: 25px;"></i>

                                                                    </button>
                                                                </td>

                                                                <td>
                                                                    <div class="d-flex justify-content-between">
                                                                        <!-- Align the first button to the left -->

                                                                        <button type='button' class='btn margin-5 showbeforeimg'
                                                                            data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                            <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                        </button>

                                                                        <!-- Align the second button to the right -->
                                                                        <button type="button" class="btn I"
                                                                            data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'
                                                                            style="margin-left:2px;" data-toggle="modal"
                                                                            data-target="#Modal4">
                                                                            <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                                <?php
                                                                echo "<td class='text-center'>" . htmlspecialchars($row['days_to_complete']) . "</td>";
                                                                echo "<td class='text-center'>" . htmlspecialchars($row['date_of_completion']) . "</td>";

                                                                ?>
                                                                <td class="text-center"><button type="button" class="btn btn-info "
                                                                        data-toggle="modal">
                                                                        Completed
                                                                    </button></td>
                                                            <?php

                                                                echo "</tr>";
                                                            }
                                                            ?>
                                                        </tbody>
                                              </table>
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
        <div class="footer-copyright" style="text-align: center; position: relative;">
            <p>
                Copyright © 2024 Designed by
                <span
                    style="background: linear-gradient(to right, #cb2d3e, #ef473a); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    Technology Innovation Hub - MKCE.
                </span>
                All rights reserved.
            </p>
        </div>
    </footer>

    <!-- View Complaint Modal Starts -->
    <div class="modal fade" id="complaint" tabindex="-1" role="dialog"
        aria-labelledby="complaintDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="complaintDetailsModalLabel">
                        📋 Complaint Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

                    <!-- Complaint Info Section arranged in two-column layout -->
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="fw-bold">Faculty ID</label>
                                <div class="text-muted"><b id="id"></b></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="fw-bold">Faculty Name</label>
                                <div class="text-muted"><b id="faculty_name"></b></div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="fw-bold">Mobile Number

                                </label>
                                <div class="text-muted"><b id="faculty_contact"></b></div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="fw-bold">E-mail</label>
                                <div class="text-muted"><b id="faculty_mail"></b></div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="fw-bold">Type of Problem</label>
                                <div class="text-muted"><b id="fac_name"></b></div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="fw-bold">Problem Description</label>
                                <div class="text-muted"><b id="fac_id"></b></div>
                            </div>
                        </div>

                        <!-- New row for Venue and Type of Problem -->


                        <!-- Full width for Problem Description -->

                    </div>

                </div>

                <!-- Modal Footer with Save Button -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- View Complaint Modal Ends -->
    <!-- Before Image Modal Starts -->
    <div class="modal fade" id="Modal4" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header" style="background: linear-gradient(to bottom right, #cc66ff, #0033cc); color: white;">
                    <h5 class="modal-title" id="imageModalLabel">Problem Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <form id="rejectreason">
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" alt="Image" class="img-fluid rounded shadow" style="max-height: 400px; width: auto;">
                        <!-- src will be set dynamically -->
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Before Image Model Ends -->

    <!-- Problem Description Modal -->

    <div class="modal fade" id="Modal1" tabindex="-1" role="dialog"
        aria-labelledby="complaintDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="complaintDetailsModalLabel">
                        📋 Complaint Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <ul class="list-group">
                        
                        <li class="list-group-item">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold text-primary">Faculty Name</div>
                                <b><span id="vfaculty_name" class="text-secondary"></span></b>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold text-primary">Mobile Number</div>
                                <b><span id="vfaculty_contact" class="text-secondary"></span></b>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold text-primary">Block name</div>
                                <b><span id="vblock-content" class="text-secondary"></span></b>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold text-primary">Venue name</div>
                                <b><span id="vvenue-content" class="text-secondary"></span></b>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold text-primary">Problem Description</div>
                                <div class="alert alert-light border rounded">
                                    <b><span id="vproblem-description-content" class="text-secondary"></span></b>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary btn-lg rounded-pill" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
              


            </div>
        </div>
    </div>


    <div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Task Completion</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- form -->
                                <form id="taskCompletionForm">
                                    <div class="mb-3">
                                        <label class="form-label">Task ID</label>
                                        <input type="text" class="form-control" id="taskid" value="{{ $d1->task_id ?? ''}}" disabled readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="worker" class="font-weight-bold">Assign Worker:</label>
                                        <select class="form-control" name="worker" id="worker">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" id="oth" name="oth" onclick="checkIfOthers()">
                                        Others
                                    </div>
                                    <div id="othersInput" class="hidden-input">
                                        <label class="form-label" for="otherValue">Please specify:</label>
                                        <input placeholder="Enter worker details" type="text" id="otherValue" name="otherworkername">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Add Image-Proof</label>
                                        <input onchange="validateSize(this)" class="form-control" type="file" id="imgafter" name="after_photo">
                                    </div>
                                    <label class="form-label">Task Completion</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="completionStatus" id="inlineRadio1" value="Fully Completed">
                                        <label class="form-check-label" for="inlineRadio1">Fully Completed</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="completionStatus" id="inlineRadio2" value="Partially Completed">
                                        <label class="form-check-label" for="inlineRadio2">Partially Completed</label>
                                    </div>
                                    <!-- Hidden input field for reason -->
                                    <div class="mb-3 mt-3" id="reason-container" class="hidden-input">
                                        <label class="form-label">Reason</label>
                                        <input type="text" class="form-control" id="reason" name="reason" placeholder="Enter reason for partial completion">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="save-btn" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--image before and complaint start-->
                <div class="modal fade" id="Modal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Image-Before</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img id="modalImage1" src="" width="100%">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                <div class="modal fade" id="Modal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Image-After</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img id="modalImage" src="" width="100%">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

    <script src="assets/script/script.js"></script>
    <script src="assets/script/bootstrap.js"></script>

    <!-- DataTables Initialization -->
    <script>
            $(function() {
                // Initialize the tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // You can also set options manually if needed
                $('.view-complaint').tooltip({
                    placement: 'top',
                    title: 'View Complaint'
                });
            });


            $(function() {
                // Initialize the tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // You can also set options manually if needed
                $('.showbeforeimg').tooltip({
                    placement: 'top',
                    title: 'Before'
                });
            });



            $(function() {
                // Initialize the tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // You can also set options manually if needed
                $('.showImage').tooltip({
                    placement: 'top',
                    title: 'Before'
                });
            });
            $(document).ready(function() {
                // Initialize DataTables
              
                var inProgTable = $('#complaint_table').DataTable({
                
                });
                var apprTable = $('#waitingapproval_table').DataTable({
                    
                });
                var compTable = $('#newtask_table').DataTable({
                    
                });
                var notApprTable = $('#notapproved_table').DataTable({
                    
                });


            });
        </script>
        <script>
            //viewing complaint details in modal
            $(document).on('click', '.view-complaint', function(e) {
                e.preventDefault();
                var taskId = $(this).data('task-id');

                $.ajax({
                    url: 'cms_backend.php?action=wviewcomp',
                    type: 'POST',
                    data: {
                        task_id: taskId
                    },
                    success: function(response) {
                        console.log("Raw response:", response);

                        // If response is a JSON string, parse it
                        var data = typeof response === "string" ? JSON.parse(response) : response;

                        if (data.error) {
                            alert(data.error);
                        } else {


                            // Update modal content with data
                            $('#vfaculty_name').text(data.faculty_name);
                            $('#vfaculty_contact').text(data.faculty_contact);
                            $('#vblock-content').text(data.block_venue);
                            $('#vvenue-content').text(data.venue_name);
                            $('#vproblem-description-content').text(data.problem_description);

                            // Show modal
                            $('#Modal1').modal('show');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("AJAX error:", textStatus, errorThrown);
                        alert('Failed to fetch details');
                    }
                });
            });
        </script>
        <script>
            //work completed status in inprogress table
            $(document).on('click', '.work-comp', function(e) {
                e.preventDefault();
                var taskId = $(this).data('task-id');
                console.log(taskId);
                $('#Modal2').modal('show');

                $('#taskid').val(taskId);

            });
        </script>
        <script>
           $('input[id="inlineRadio1"]').on('change', function() {
                if ($(this).val() === 'Fully Completed') {
                    $('#reason-container').hide();
                }
            });

            $('input[id="inlineRadio2"]').on('change', function() {
                if ($(this).val() === 'Partially Completed') {
                    $('#reason-container').show();
                }
            });



            // Handle save button click for work completion
            $(document).on('click', '#save-btn', function(e) {
                var taskId = $('#taskid').val();
                console.log("this id:",taskId);
                var completionStatus = $('input[name="completionStatus"]:checked').val();
                var imgAfter = $('#imgafter')[0].files[0];
                var reason = $('#reason').val(); // Capture reason from the input field
                var w_name = $('#worker').val();
                var o_name = $('#otherValue').val();
                var amt = $('#amtspent').val();
                var p_id = $('#complaint_id77').val();
                console.log(w_name);
                console.log(o_name);

                if (!taskId || !completionStatus) {
                    Swal.fire({
                        title: "Invalid!",
                        text: "Please provide all required information.",
                        icon: "error"
                    });
                    return;
                }

                // Prepare form data for submission
                var formData = new FormData();
                formData.append("update", true);
                formData.append('task_id', taskId);
                formData.append('completion_status', completionStatus);
                formData.append('reason', reason); // Append reason to form data
                formData.append('w_name', w_name);
                formData.append('o_name', o_name);
                formData.append('p_id', p_id);
                formData.append('amt', amt);

                if (imgAfter) {
                    formData.append('img_after', imgAfter);
                }
                for (const [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }

                // AJAX request to submit the form data
                $.ajax({
                    url: 'cms_backend.php?action=workcompletion',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert("done");
                        $('#Modal2').modal('hide');

                        // Refresh specific sections dynamically
                        setTimeout(function() {
                            $('#ref1').load(location.href + " #ref1");
                            $('#ref2').load(location.href + " #ref2");

                            $('#ref3').load(location.href + " #ref3");

                            $('#ref4').load(location.href + " #ref4");

                            $('#ref5').load(location.href + " #ref5");
                            
                            $('#complaint_table').DataTable().destroy();

                            $("#complaint_table").load(location.href + " #complaint_table > *", function() {
                                // Reinitialize the DataTable after the content is loaded
                                $('#complaint_table').DataTable();
                            });

                            $('#waitingapproval_table').DataTable().destroy();

                            $("#waitingapproval_table").load(location.href + " #waitingapproval_table > *", function() {
                                // Reinitialize the DataTable after the content is loaded
                                $('#waitingapproval_table').DataTable();
                            });

                            $('#completed_table').DataTable().destroy();

                            $("#addnewtaskcompleted").load(location.href + " #addnewtaskcompleted > *", function() {
                                // Reinitialize the DataTable after the content is loaded
                                $('#addnewtaskcompleted').DataTable();
                            });

                            $('#statusnotapproved').DataTable().destroy();

                            $("#statusnotapproved").load(location.href + " #statusnotapproved > *", function() {
                                // Reinitialize the DataTable after the content is loaded
                                $('#statusnotapproved').DataTable();
                            });

                        }, 500); // Adding a delay to ensure the sections are reloaded after the update
                    },
                    error: function() {
                        Swal.fire({
                            title: "Invalid!",
                            text: "An error occurred. Please try again.",
                            icon: "error"
                        });
                    }
                });
                sendmailCompletion(taskId);
            });

            function sendmailCompletion(id){
                $.ajax({
        type: "POST",
        url: "cms_mail.php",
        data: {
            'work_completed': true,
            'id': id,
        },
        success: function (response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 200) {
                console.log("Mail sent successfully!!");
            }
        },
        error: function (xhr, status, error) {
            console.error("Mail AJAX error:", error);
        }
    });                
            }

            function checkIfOthers() {
                const dropdown = document.getElementById('oth');
                const othersInput = document.getElementById('othersInput');
                const sel = document.getElementById('worker');

                // Show the input field if "Others" is selected
                if (dropdown.checked) {
                    othersInput.style.display = 'block';
                    sel.value = "";
                } else {
                    othersInput.style.display = 'none';

                }
            }

            // Show the reason input field only when 'Partially Completed' is selected
        </script>
        <script>
            //after image showing
            // Show image
            // Show image
            $(document).on('click', '.I', function(e) {
                e.preventDefault(); // Prevent form submission
                var task_id = $(this).data('task-id');
                console.log(task_id);

                $.ajax({
                    type: "POST",
                    url: 'cms_backend.php?action=wafterimage',
                    data: {
                        'task_id': task_id
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);

                        if (response.status == 200) {
                            console.log('Image Path:', response.data.after_photo);

                            if (response.data.after_photo) {
                                $('#modalImage').attr('src', response.data.after_photo);
                            } else {
                                alert('No image found.');
                            }

                            $('#Modal4').modal('show');
                        } else {
                            alert(response.message || 'An error occurred while retrieving the image.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: ", xhr.responseText);
                        alert('An error occurred: ' + error + "\nStatus: " + status + "\nDetails: " + xhr.responseText);
                    }
                });
            });
        </script>
        <script>
            //before image showing
            // Show image
            // Show image
            $(document).on('click', '.showbeforeimg', function(e) {
                e.preventDefault();
                var task_id = $(this).data('task-id');
                console.log(task_id);

                $.ajax({
                    type: "POST",
                    url: 'cms_backend.php?action=wbeforeimg',
                    data: {
                        'task_id': task_id
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);

                        if (response.status == 200) {
                            console.log('Image Path:', response.data.after_photo);

                            if (response.data.after_photo) {
                                $('#modalImage1').attr('src', response.data.after_photo);
                            } else {
                                alert('No image found.');
                            }

                            $('#Modal3').modal('show');
                        } else {
                            alert(response.message || 'An error occurred while retrieving the image.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: ", xhr.responseText);
                        alert('An error occurred: ' + error + "\nStatus: " + status + "\nDetails: " + xhr.responseText);
                    }
                });
            });
        </script>
        <script>
            //file validation after image
            function validateSize(input) {
                const fileSize = input.files[0].size / 1024;
                var ext = input.value.split(".");
                ext = ext[ext.length - 1].toLowerCase();
                var arrayExtensions = ["jpg", "jpeg", "png"];
                if (arrayExtensions.lastIndexOf(ext) == -1) {
                    alert("Invalid file type");
                    $(input).val('');

                } else if (fileSize > 2048057) {
                    alert("file is too large");
                    $(input).val('');
                }

            }


            $(document).on("click", ".work-comp", function(e) {
                e.preventDefault();

                var user_id = $(this).val(); // Get the ID from the button's value
                console.log("User ID:", user_id);

                // Set the complaint ID in the hidden input field within the form
                $("#complaint_id77").val(user_id);

                // Reset the worker selection and the text in the modal
                $("#worker_id").val(''); // Reset the worker ID
                $("#assignedWorker").text('Assigned Worker: '); // Reset the assigned worker text
            });

            $(document).on("click", ".work-comp", function(e) {
                e.preventDefault();
                var worker_dept = $(this).data("value");
                console.log(worker_dept);

                $.ajax({
                    url: 'cms_backend.php?action=wworkerassign',
                    type: "POST",
                    data: {
                        "worker_dept": worker_dept
                    },
                    success: function(response) {
                        // Inject the received HTML options into the <select> element
                        $('#worker').html(response);
                    }
                });
            });



            $(document).ready(function() {
                $('.start-work-btn').click(function(e) {
                    e.preventDefault();
                    var taskId = $(this).data('task-id');
                    console.log(taskId);

                    $.ajax({
                        url: 'cms_backend.php?action=wrestart',
                        type: 'POST',
                        data: {
                            start_work: true,
                            task_id: taskId
                        },
                        success: function(response) {
                            var res = jQuery.parseJSON(response);
                            if (res.status == 200) {
                                $('#addnewtask').DataTable().destroy();

                                $("#addnewtask").load(location.href + " #addnewtask > *", function() {
                                    // Reinitialize the DataTable after the content is loaded
                                    $('#addnewtask').DataTable();
                                });
                                $('#statusinprogress').DataTable().destroy();

                                $("#statusinprogress").load(location.href + " #statusinprogress > *", function() {
                                    // Reinitialize the DataTable after the content is loaded
                                    $('#statusinprogress').DataTable();
                                });

                                $('#approval').DataTable().destroy();

                                $("#approval").load(location.href + " #approval > *", function() {
                                    // Reinitialize the DataTable after the content is loaded
                                    $('#approval').DataTable();
                                });

                                $('#addnewtaskcompleted').DataTable().destroy();

                                $("#completed_table").load(location.href + " #completed_table > *", function() {
                                    // Reinitialize the DataTable after the content is loaded
                                    $('#completed_table').DataTable();
                                });

                                $('#notapproved_table').DataTable().destroy();

                                $("#notapproved_table").load(location.href + " #notapproved_table > *", function() {
                                    // Reinitialize the DataTable after the content is loaded
                                    $('#notapproved_table').DataTable();
                                });

                                $('#ref1').load(location.href + " #ref1");
                                $('#ref2').load(location.href + " #ref2");

                                $('#ref3').load(location.href + " #ref3");

                                $('#ref4').load(location.href + " #ref4");

                                $('#ref5').load(location.href + " #ref5");




                            } else {
                                alert('Something went wrong')
                            }
                        }
                    });
                });
            });
        </script>


</body>

</html>