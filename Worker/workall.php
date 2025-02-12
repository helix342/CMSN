<?php
require "config.php";
include("session.php");


$worker_id = $s;
if(!($worker_id)){
    header("Location:index.php");

}

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
    <title>MIC</title>
    <link rel="icon" type="image/png" sizes="32x32" href="image/icons/mkce_s.png">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-5/bootstrap-5.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
            --topbar-height: 60px;
            --footer-height: 60px;
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --dark-bg: #1a1c23;
            --light-bg: #f8f9fc;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* General Styles with Enhanced Typography */

        /* Content Area Styles */
        .content {
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-height);
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        /* Content Navigation */
        .content-nav {
            background: linear-gradient(45deg, #4e73df, #1cc88a);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .content-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 20px;
            overflow-x: auto;
        }

        .content-nav li a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .content-nav li a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .sidebar.collapsed+.content {
            margin-left: var(--sidebar-collapsed-width);
        }

        .breadcrumb-area {
            background: white;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            margin: 20px;
            padding: 15px 20px;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .breadcrumb-item a:hover {
            color: #224abe;
        }



        /* Table Styles */



        .gradient-header {
            --bs-table-bg: transparent;
            --bs-table-color: white;
            background: linear-gradient(135deg, #4CAF50, #2196F3) !important;

            text-align: center;
            font-size: 0.9em;


        }


        td {
            text-align: left;
            font-size: 0.9em;
            vertical-align: middle;
            /* For vertical alignment */
        }






        /* Responsive Styles */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width) !important;
            }

            .sidebar.mobile-show {
                transform: translateX(0);
            }

            .topbar {
                left: 0 !important;
            }

            .mobile-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
                display: none;
            }

            .mobile-overlay.show {
                display: block;
            }

            .content {
                margin-left: 0 !important;
            }

            .brand-logo {
                display: block;
            }

            .user-profile {
                margin-left: 0;
            }

            .sidebar .logo {
                justify-content: center;
            }

            .sidebar .menu-item span,
            .sidebar .has-submenu::after {
                display: block !important;
            }

            body.sidebar-open {
                overflow: hidden;
            }

            .footer {
                left: 0 !important;
            }

            .content-nav ul {
                flex-wrap: nowrap;
                overflow-x: auto;
                padding-bottom: 5px;
            }

            .content-nav ul::-webkit-scrollbar {
                height: 4px;
            }

            .content-nav ul::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.3);
                border-radius: 2px;
            }
        }

        .container-fluid {
            padding: 20px;
        }


        /* loader */
        .loader-container {
            position: fixed;
            left: var(--sidebar-width);
            right: 0;
            top: var(--topbar-height);
            bottom: var(--footer-height);
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            /* Changed from 'none' to show by default */
            justify-content: center;
            align-items: center;
            z-index: 1000;
            transition: left 0.3s ease;
        }

        .sidebar.collapsed+.content .loader-container {
            left: var(--sidebar-collapsed-width);
        }

        @media (max-width: 768px) {
            .loader-container {
                left: 0;
            }
        }

        /* Hide loader when done */
        .loader-container.hide {
            display: none;
        }

        /* Loader Animation */
        .loader {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-radius: 50%;
            border-top: 5px solid var(--primary-color);
            border-right: 5px solid var(--success-color);
            border-bottom: 5px solid var(--primary-color);
            border-left: 5px solid var(--success-color);
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .breadcrumb-area {
            background-image: linear-gradient(to top, #fff1eb 0%, #ace0f9 100%);
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            margin: 20px;
            padding: 15px 20px;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .breadcrumb-item a:hover {
            color: #224abe;
        }
        .nav-tabs .nav-link {
    background: transparent; /* Default state - colorless */
    color: black; /* Default text color */
    border: none; /* Remove border */
    margin: 2px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.nav-tabs .nav-link.active {
    background: linear-gradient(135deg, rgb(78, 101, 255), rgb(146, 239, 253));
    color: white; /* Text color for active tab */
    font-weight: bold;
}

.nav-tabs .nav-link:hover {
    background: linear-gradient(135deg, rgb(78, 101, 255), rgb(146, 239, 253));
    color: white;
}
.card-title {
    position: relative;
    font-weight: 500;
    margin-bottom: 10px;
}
h5 {
    font-size: 16px;
    font-family: inherit;
    color: inherit;
    display: block;
    font-size: 0.83em;
    margin-block-start: 1.67em;
    margin-block-end: 1.67em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
    unicode-bidi: isolate;
}
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="content">

        <div class="loader-container" id="loaderContainer">
            <div class="loader"></div>
        </div>

        <!-- Topbar -->
        <?php include 'topbar.php'; ?>      

        <!-- Content Area -->
<div class="container-fluid">
    <div class="custom-tabs">
        <!-- Bootstrap Tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#inprogressdiv" role="tab">InProgress(<?php echo $progcount ?>)</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#waitingforapproval" role="tab">WaitingForApproval(<?php echo $waitcount ?>)</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#notapproved" role="tab">NotApproved(<?php echo $notcount ?>)</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#completed" role="tab">Completed(<?php echo $compcount ?>)</a>
    </li>
</ul>

<div class="tab-content">
    <!-- In Progress -->
    <div class="tab-pane fade show active p-20" id="inprogressdiv" role="tabpanel">
        <h5 class="card-title">In Progress</h5>
        <div class="table-responsive">
            <table id="statusinprogress" class="table table-striped table-bordered">
                <thead class="gradient-header">
                    <tr>
                        <th>S.No</th>
                        <th>Complaint Date</th>
                        <th>Task ID</th>
                        <th>Dept</th>
                        <th>Complaint</th>
                        <th>Priority</th>
                        <th>Photos</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
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

    <!-- Waiting for Approval -->
    <div class="tab-pane fade p-20" id="waitingforapproval" role="tabpanel">
        <h5 class="card-title">Waiting for Approval</h5>
        <div class="table-responsive">
            <table id="approval" class="table table-striped table-bordered">
                <thead class="gradient-header">
                    <tr>
                        <th>S.No</th>
                        <th>Complaint Date</th>
                        <th>Task ID</th>
                        <th>Dept</th>
                        <th>Complaint</th>
                        <th>Priority</th>
                        <th>Photos</th>
                        <th>Deadline</th>
                        <th>Reason</th>
                        <th>Task Completion</th>
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

    <!-- Not Approved -->
    <div class="tab-pane fade p-20" id="notapproved" role="tabpanel">
        <h5 class="card-title">Not Approved</h5>
        <div class="table-responsive">
            <table id="statusnotapproved"class="table table-striped table-bordered">
                <thead class="gradient-header">
                    <tr>
                        <th>S.No</th>
                        <th>Complaint Date</th>
                        <th>Task ID</th>
                        <th>Dept</th>
                        <th>Complaint</th>
                        <th>Priority</th>
                        <th>Photos</th>
                        <th>Deadline</th>
                        <th>Reason</th>
                        <th>Status</th>
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

    <!-- Completed -->
    <div class="tab-pane fade p-20" id="completed" role="tabpanel">
        <h5 class="card-title">Completed Tasks</h5>
        <div class="table-responsive">
            <table id="addnewtaskcompleted" class="table table-striped table-bordered">
                <thead class="gradient-header">
                    <tr>
                        <th>S.No</th>
                        <th>Complaint Date</th>
                        <th>Task ID</th>
                        <th>Dept</th>
                        <th>Complaint</th>
                        <th>Photos</th>
                        <th>Deadline</th>
                        <th>Date of Completion</th>
                        <th>Status</th>
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

<!-- Photo Modal -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Photo Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Photo" class="img-fluid">
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
        <!-- Footer -->
        <?php include 'footer.php'; ?>
    </div>
    <script>
        const loaderContainer = document.getElementById('loaderContainer');

        function showLoader() {
            loaderContainer.classList.add('show');
        }

        function hideLoader() {
            loaderContainer.classList.remove('show');
        }

        //    automatic loader
        document.addEventListener('DOMContentLoaded', function() {
            const loaderContainer = document.getElementById('loaderContainer');
            const contentWrapper = document.getElementById('contentWrapper');
            let loadingTimeout;

            function hideLoader() {
                loaderContainer.classList.add('hide');
                contentWrapper.classList.add('show');
            }

            function showError() {
                console.error('Page load took too long or encountered an error');
                // You can add custom error handling here
            }

            // Set a maximum loading time (10 seconds)
            loadingTimeout = setTimeout(showError, 10000);

            // Hide loader when everything is loaded
            window.onload = function() {
                clearTimeout(loadingTimeout);

                // Add a small delay to ensure smooth transition
                setTimeout(hideLoader, 500);
            };

            // Error handling
            window.onerror = function(msg, url, lineNo, columnNo, error) {
                clearTimeout(loadingTimeout);
                showError();
                return false;
            };
        });

        // Toggle Sidebar
        const hamburger = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');
        const body = document.body;
        const mobileOverlay = document.getElementById('mobileOverlay');

        function toggleSidebar() {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('mobile-show');
                mobileOverlay.classList.toggle('show');
                body.classList.toggle('sidebar-open');
            } else {
                sidebar.classList.toggle('collapsed');
            }
        }
        hamburger.addEventListener('click', toggleSidebar);
        mobileOverlay.addEventListener('click', toggleSidebar);
        // Toggle User Menu
        const userMenu = document.getElementById('userMenu');
        const dropdownMenu = userMenu.querySelector('.dropdown-menu');

        userMenu.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', () => {
            dropdownMenu.classList.remove('show');
        });

        // Toggle Submenu
        const menuItems = document.querySelectorAll('.has-submenu');
        menuItems.forEach(item => {
            item.addEventListener('click', () => {
                const submenu = item.nextElementSibling;
                item.classList.toggle('active');
                submenu.classList.toggle('active');
            });
        });

        // Handle responsive behavior
        window.addEventListener('resize', () => {
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('collapsed');
                sidebar.classList.remove('mobile-show');
                mobileOverlay.classList.remove('show');
                body.classList.remove('sidebar-open');
            } else {
                sidebar.style.transform = '';
                mobileOverlay.classList.remove('show');
                body.classList.remove('sidebar-open');
            }
        });
    </script>
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
        <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
        <script src="assets/extra-libs/sparkline/sparkline.js"></script>
        <!--Wave Effects -->
        <script src="dist/js/waves.js"></script>
        <!--Menu sidebar -->
        <script src="dist/js/sidebarmenu.js"></script>
        <!--Custom JavaScript -->
        <script src="dist/js/custom.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
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
                var addTable = $('#addnewtask').DataTable({
                    ordering: false
                });
                var inProgTable = $('#statusinprogress').DataTable({
                    ordering: false
                });
                var apprTable = $('#approval').DataTable({
                    ordering: false
                });
                var compTable = $('#addnewtaskcompleted').DataTable({
                    ordering: false
                });
                var notApprTable = $('#statusnotapproved').DataTable({
                    ordering: false
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
                            $('#faculty_name').text(data.faculty_name);
                            $('#contact').text(data.faculty_contact);
                            $('#block-content').text(data.block_venue);
                            $('#venue-content').text(data.venue_name);
                            $('#problem-description-content').text(data.problem_description);
                            $('#days-remaining-content').text(data.days_to_complete);

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
                        Swal.fire({
                            title: "Updated!",
                            text: "Work is Completed",
                            icon: "success"
                        });
                        $('#Modal2').modal('hide');

                        // Refresh specific sections dynamically
                        setTimeout(function() {
                            $('#ref1').load(location.href + " #ref1");
                            $('#ref2').load(location.href + " #ref2");

                            $('#ref3').load(location.href + " #ref3");

                            $('#ref4').load(location.href + " #ref4");

                            $('#ref5').load(location.href + " #ref5");
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
            });

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

                                $("#addnewtaskcompleted").load(location.href + " #addnewtaskcompleted > *", function() {
                                    // Reinitialize the DataTable after the content is loaded
                                    $('#addnewtaskcompleted').DataTable();
                                });

                                $('#statusnotapproved').DataTable().destroy();

                                $("#statusnotapproved").load(location.href + " #statusnotapproved > *", function() {
                                    // Reinitialize the DataTable after the content is loaded
                                    $('#statusnotapproved').DataTable();
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
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
        // DataTables
        $(document).ready(function() {
            $('#statusinprogress').DataTable();
            $('#approval').DataTable();
            $('#statusnotapproved').DataTable();
            $('#addnewtaskcompleted').DataTable();
        });
    </script>

   
</body>

</html>