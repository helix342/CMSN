<?php
require 'config.php';
include('session.php');
$faculty_id = $s;
// $role  = $frole;
// if ($role != "principal") {
//     header("Location:index.php");
// }
$sql12 = "SELECT * FROM complaints_detail WHERE status IN (11,18,14) AND faculty_id = '$faculty_id'";
$result12 = mysqli_query($db, $sql12);
$row_count12 = mysqli_num_rows($result12);


//work completed table
$sql1 = "SELECT * FROM complaints_detail WHERE status='16'";
$result1 = mysqli_query($db, $sql1);

$sql6 = "SELECT * FROM complaints_detail WHERE faculty_id='$faculty_id' AND status IN (11, 22)";
$result6 = mysqli_query($db, $sql6);


//pending count
$sql3 = "SELECT complaints_detail.*,manager.* FROM complaints_detail LEFT JOIN manager on complaints_detail.id=manager.problem_id WHERE status = 7";
$result3 = mysqli_query($db, $sql3);
$compcount1 = mysqli_num_rows($result3);

//inprogress count
$sql4 = "SELECT complaints_detail.*,manager.* FROM complaints_detail LEFT JOIN manager on complaints_detail.id=manager.problem_id WHERE status = 10";
$result4 = mysqli_query($db, $sql4);
$compcount2 = mysqli_num_rows($result4);

//reassigned work
$sql5 = "SELECT complaints_detail.*,manager.* FROM complaints_detail LEFT JOIN manager on complaints_detail.id=manager.problem_id WHERE status = 14";
$result5 = mysqli_query($db, $sql5);
$compcount3 = mysqli_num_rows($result5);

$sql11 = "SELECT * FROM complaints_detail WHERE status='6'";
$result11 = mysqli_query($db, $sql11);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIC</title>
    <link rel="icon" type="image/png" sizes="32x32" href="image/icons/mkce_s.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styles.css">
    <link href="../css/dboardstyles.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/tabs.css">
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
    </style>
    <style>
    /* Sidebar Styles */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: var(--sidebar-width);
        background: var(--dark-bg);
        transition: var(--transition);
        z-index: 1000;
        overflow-y: auto;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        background-image: url('../image/pattern_h.png');
    }

    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
    }

    .sidebar.collapsed {
        width: var(--sidebar-collapsed-width);
    }

    .sidebar .logo {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 20px;
        color: white;
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar .logo img {
        max-height: 90px;
        width: auto;
    }

    .sidebar .s_logo {
        display: none;
    }

    .sidebar.collapsed .logo img {
        display: none;
    }

    .sidebar.collapsed .logo .s_logo {
        display: flex;
        max-height: 50px;
        width: auto;
        align-items: center;
        justify-content: center;
    }

    .sidebar .menu {
        padding: 10px;
    }

    .menu-item {
        padding: 12px 15px;
        color: rgba(255, 255, 255, 0.7);
        display: flex;
        align-items: center;
        cursor: pointer;
        border-radius: 5px;
        margin: 4px 0;
        transition: all 0.3s ease;
        position: relative;
        text-decoration: none;
    }

    .menu-item:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .menu-item i {
        min-width: 30px;
        font-size: 18px;
    }

    .menu-item span {
        margin-left: 10px;
        transition: all 0.3s ease;
        flex-grow: 1;
    }

    .menu-item.active {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        font-weight: bold;
    }

    .menu-item.active i {
        color: white;
    }

    .has-submenu::after {
        content: '\f107';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        margin-left: 10px;
        transition: transform 0.3s ease;
    }

    .has-submenu::after {
        content: '\f107';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        margin-left: 10px;
        transition: transform 0.3s ease;
    }

    .has-submenu.active::after {
        transform: rotate(180deg);
    }

    .sidebar.collapsed .menu-item span,
    .sidebar.collapsed .has-submenu::after {
        display: none;
    }

    .submenu {
        margin-left: 30px;
        display: none;
        transition: all 0.3s ease;
    }

    .submenu.active {
        display: block;
    }


    /* Gradient Colors */
    .icon-basic {
        background: linear-gradient(45deg, #4facfe, #00f2fe);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .icon-academic {
        background: linear-gradient(45deg, rgb(66, 245, 221), #00d948);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .icon-exam {
        background: linear-gradient(45deg, rgb(255, 145, 0), rgb(245, 59, 2));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .icon-bus {

        background: #9C27B0;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .icon-feedback {
        background: #E91E63;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .icon-password {
        background: #607D8B;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .welcome-card {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        border: none;
        border-radius: 15px;
        color: white;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        margin: 0 0 20px 0;
        height: 150px;
        /* Increased from 120px */
    }

    .welcome-stats {
        display: flex;
        gap: 15px;
        margin-top: 15px;
    }

    .stat-item {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        border-radius: 50%;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
        animation: slideInUp 0.5s ease forwards;
        animation-delay: calc(var(--animation-order) * 0.1s);
        opacity: 0;
        color: white;
        z-index: 1;
        aspect-ratio: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px;
        width: 100%;
        max-width: 200px;
        margin: 0 auto;
    }

    .stat-item:hover {
        transform: translateY(-10px) scale(1.05);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .stat-item::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg,
                transparent,
                rgba(255, 255, 255, 0.1),
                transparent);
        transform: rotate(45deg);
        animation: shine 3s infinite;
        z-index: -1;
    }

    @keyframes shine {
        0% {
            transform: rotate(45deg) translateX(-100%);
        }

        100% {
            transform: rotate(45deg) translateX(100%);
        }
    }

    .stat-number {
        font-size: 2.2rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 5px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        position: relative;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #ffffff;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        text-align: center;
    }

    .stat-icon {
        font-size: 2rem;
        margin-bottom: 10px;
        color: rgba(255, 255, 255, 0.9);
    }

    @keyframes slideInUp {
        from {
            transform: translateY(30px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }

    .stats-row {
        margin-top: 30px;
        /* Increased from -10px */
        margin-bottom: 30px;
        padding-top: 20px;
    }

    @media (max-width: 768px) {
        .welcome-text {
            font-size: 1.8rem;
        }

        .welcome-card {
            height: 250px;
            /* Increased mobile height */
        }
    }

    .stat-item .fas.fa-clock {
        animation: pulse 2s infinite;
    }

    .stat-item .fas.fa-spinner {
        animation: spin 2s linear infinite;
    }

    .stat-item .fas.fa-check-circle {
        animation: bounce 2s infinite;
    }
    </style>
</head>

<body>
    <div class="mobile-overlay" id="mobileOverlay"></div>
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <img src="image/mkce.png" alt="College Logo">
            <img class='s_logo' src="image/mkce_s.png" alt="College Logo">
        </div>

        <div class="menu">
            <a href="smain.php" class="menu-item">
                <i class="fas fa-home text-primary"></i>
                <span>Dashboard</span>
            </a>

            <a href="sprofile.php" class="menu-item">
                <i class="fas fa-user text-warning"></i>
                <span>Profile</span>
            </a>
            <a href="cms_principal.php" class="menu-item active">
                <i class="fas fa-exclamation-triangle icon-feedback"></i>
                <span>Greivances</span>
            </a>
            <a href="spwd.php" class="menu-item">
                <i class="fas fa-key icon-password"></i>
                <span>Change Password</span>
            </a>
        </div>
    </div>


    <!-- Main Content -->
    <div class="content">

        <div class="loader-container" id="loaderContainer">
            <div class="loader"></div>
        </div>

        <!-- Topbar -->
        <?php include 'topbar.php'; ?>

        <!-- Breadcrumb -->
        <div class="breadcrumb-area custom-gradient">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Research</li>
                </ol>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="container-fluid">
            <div class="custom-tabs">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#dashboard" role="tab"
                            aria-selected="true" id="view-bus-tab">
                            <span class="hidden-xs-down" style="font-size: 0.9em;">
                                <i class="fas fa-list-alt tab-icon"></i> Dashboard
                            </span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#requirements" role="tab"
                            aria-selected="true" id="add-bus-tab">
                            <span class="hidden-xs-down" style="font-size: 0.9em;">
                                <i class="fas fa-list-alt tab-icon"></i> Requirements
                            </span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#completed" role="tab"
                            aria-selected="false" id="edit-bus-tab">
                            <span class="hidden-xs-down" style="font-size: 0.9em;">
                                <i class="fas fa-check-circle tab-icon"></i> Completed Work
                            </span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#inprogress" role="tab"
                            aria-selected="false" id="route-bus-tab">
                            <span class="hidden-xs-down" style="font-size: 0.9em;">
                                <i class="fas fa-tasks tab-icon"></i> Work Assigned
                            </span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#complaints" role="tab"
                            aria-selected="false" id="schedule-bus-tab">
                            <span class="hidden-xs-down" style="font-size: 0.9em;">
                                <i class="fas fa-exclamation-circle tab-icon"></i> &nbsp My Complaints
                            </span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#waitfeed" role="tab"
                            aria-selected="false" id="settings-bus-tab">
                            <span class="hidden-xs-down" style="font-size: 0.9em;">
                                <i class="fas fa-comments tab-icon"></i> &nbsp Feedback
                            </span>
                        </a>
                    </li>
                </ul>
            </div>



            <div class="tab-content">
                <div class="tab-pane fade show active p-20" id="dashboard" role="tabpanel">
                <div class="card">
                        <div class="card-body">
                            <!-- <div class="card-header"> -->
                            <h4 class="card-title m-b-0"><b></b></h4><br>

                            <br>
                            <div class="row">
                                <!-- Pending -->
                                <div class="col-12 col-md-3" style="margin-bottom: 40px">
                                    <div class="cir">
                                        <div class="bo">
                                            <div class="content1">
                                                <div class="stats-box text-center p-3" style="background-color:orange;">
                                                    <i class="fas fa-clock"></i>
                                                    <h1 class="font-light text-white">
                                                        <?php echo $row_count1;
                                                        ?>
                                                    </h1>
                                                    <small class="font-light">Pending</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Approved -->
                                <div class="col-12 col-md-3">
                                    <div class="cir">
                                        <div class="bo">
                                            <div class="content1">
                                                <div class="stats-box text-center p-3" style="background-color:rgb(14, 86, 239);">
                                                    <i class="fas fa-check"></i>
                                                    <h1 class="font-light text-white">
                                                        <?php echo $row_count3;
                                                        ?>
                                                    </h1>
                                                    <small class="font-light">Request</small>
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
                                                <div class="stats-box text-center p-3" style="background-color:rgb(70, 160, 70);">
                                                    <i class="fa-solid fa-check-double"></i>
                                                    <h1 class="font-light text-white">
                                                        <?php echo $row_count2;
                                                        ?>
                                                    </h1>
                                                    <small class="font-light">In Progress</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Rejected -->
                                <div class="col-12 col-md-3">
                                    <div class="cir">
                                        <div class="bo">
                                            <div class="content1">
                                                <div class="stats-box text-center p-3" style="background-color:red;">
                                                    <i class="fa-solid fa-xmark"></i>
                                                    <h1 class="font-light text-white">
                                                        <?php echo $row_count7;
                                                        ?>
                                                    </h1>
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
                <div class="tab-pane fade p-20" id="requirements" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="Requirements" class="table table-striped table-bordered">
                                        <thead class="gradient-header">
                                            <tr>
                                                <th>S.No</th>
                                                <th>Block \ Venue</th>
                                                <th>Complaint</th>
                                                <th>Image</th>
                                                <th>Date raised</th>
                                                <th>Requirements</th>
                                                <th style="width: 200px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $s = 1;
                                                while ($row = mysqli_fetch_array($result11)) {
                                                ?>
                                            <tr>
                                                <td class="text-center" scope="row"><?php echo $s ?></td>

                                                <td class="text-center"><?php echo $row['block_venue'] ?> \
                                                    <?php echo $row['venue_name'] ?></td>

                                                <td class="text-center">
                                                    <button type="button" value="<?php echo $row['id']; ?>"
                                                        class="btn  viewcomplaint"
                                                        data-value="<?php echo $row['fac_id']; ?>">
                                                        <i class="fas fa-eye fs-4"></i>
                                                    </button>

                                                </td>


                                                <td class="text-center">
                                                    <button type="button" class="btn btn-light btn-sm showImage"
                                                        value="<?php echo $row['id']; ?>" data-bs-toggle="modal"
                                                        data-bs-target="#imageModal">
                                                        <i class="fas fa-image fs-4"></i>
                                                    </button>

                                                </td>

                                                <td class="text-center"><?php echo $row['date_of_reg'] ?></td>

                                                <td class="text-center"><?php echo $row['p_reason'] ?></td>
                                                <td class="text-center">
                                                    <button type="button" value="<?php echo $row['id'] ?>"
                                                        class="btn btn-success userapprove">
                                                        <i class="fas fa-check"></i>
                                                    </button>

                                                    <button type="button" value="<?php echo $row['id']; ?>"
                                                        class="btn btn-danger userreject" data-bs-toggle="modal"
                                                        data-bs-target="#rejectModal">
                                                        <i class="fas fa-times"></i>
                                                    </button>

                                                </td>
                                            </tr>
                                            <?php

                                                    $s++;
                                                }

                                                ?>

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade p-20" id="completed" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">


                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="Completeds" class="table table-striped table-bordered">
                                        <thead class="gradient-header">
                                            <tr>
                                                <th>S.No</th>
                                                <th>Block/Venue</th>
                                                <th>Complaint</th>
                                                <th>Deadline</th>
                                                <th>Date of Completion</th>
                                                <th>Images</th>
                                                <th>Faculty Feedback</th>
                                                <th>Status</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $s = 1;
                                                while ($row6 = mysqli_fetch_assoc($result1)) {
                                                ?>
                                            <tr>
                                                <td class="text-center"><?php echo $s ?></td>
                                                <td class="text-center">
                                                    <?php echo $row6['block_venue'] ?>/<?php echo $row6['venue_name'] ?>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" value="<?php echo $row['id']; ?>"
                                                        class="btn  viewcomplaint"
                                                        data-value="<?php echo $row['fac_id']; ?>">
                                                        <i class="fas fa-eye fs-4"></i>
                                                    </button>
                                                </td>
                                                <td class="text-center"><?php echo $row6['days_to_complete'] ?></td>
                                                <td class="text-center"><?php echo $row6['date_of_completion'] ?></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-light btn-sm showImage"
                                                        value="<?php echo $row['id']; ?>" data-bs-toggle="modal"
                                                        data-bs-target="#imageModal">
                                                        <i class="fas fa-image" style="font-size: 25px;"></i>
                                                    </button>

                                                    <button value="<?php echo $row6['id']; ?>" type="button"
                                                        class="btn btn-light btn-sm imgafter" data-bs-toggle="modal"
                                                        data-bs-target="#afterImageModal">

                                                        <i class="fas fa-images" style="font-size: 25px;"></i>
                                                    </button>
                                                </td>
                                                <td class="text-center"><?php echo $row6['feedback'] ?></td>
                                                <td class="text-center"><?php echo $row6['task_completion'] ?></td>
                                                <!-- <td>
                                                                <span class="btn btn-success">Completed</span>
                                                            </td> -->
                                            </tr>
                                            <?php
                                                    $s++;
                                                }
                                                ?>
                                        </tbody>

                                    </table>


                                </div>



                            </div>
                        </div>
                    </div>
                </div>
                <!-- Feedback Modal -->
                <div class="modal fade" id="feedback_modal" tabindex="-1" aria-labelledby="feedbackModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header"
                                style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);">
                                <h5 class="modal-title" id="feedbackModalLabel">Feedback Form</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body">
                                <form id="add_feedback">
                                    <input type="hidden" name="id" id="feedback_id"> <!-- Hidden input for ID -->

                                    <!-- Satisfaction Selection -->
                                    <div class="mb-3">
                                        <label for="satisfaction" class="form-label">Satisfaction</label>
                                        <select name="satisfaction" id="satisfaction" class="form-control" required>
                                            <option value="" disabled selected>Select an option</option>
                                            <option value="Satisfied">Satisfied</option>
                                            <option value="Not Satisfied">Reassign</option>
                                        </select>
                                    </div>

                                    <!-- Star Rating System -->
                                    <div class="mb-3">
                                        <h5>Give Rating:</h5>
                                        <div class="d-flex" id="star-rating">
                                            <span class="star" data-value="1">&#9733;</span>
                                            <span class="star" data-value="2">&#9733;</span>
                                            <span class="star" data-value="3">&#9733;</span>
                                            <span class="star" data-value="4">&#9733;</span>
                                            <span class="star" data-value="5">&#9733;</span>
                                        </div>
                                        <p id="rating-value">Rating: <span id="ratevalue">0</span></p>
                                    </div>

                                    <!-- Feedback Text Area -->
                                    <div class="mb-3">
                                        <label for="feedback" class="form-label">Feedback</label>
                                        <textarea name="feedback" id="feedback" class="form-control"
                                            placeholder="Enter Feedback" rows="4"></textarea>
                                    </div>

                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade p-20" id="inprogress" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">


                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="Inprogress" class="table table-striped table-bordered">
                                        <thead class="gradient-header">
                                            <tr>
                                                <th>S.No</th>
                                                <th>Block/Venue</th>
                                                <th>Complaint</th>
                                                <th>Assigned Date</th>
                                                <th>Deadline</th>
                                                <th>Images</th>
                                                <th>Comments</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql2 = "SELECT complaints_detail.*,manager.* FROM complaints_detail LEFT JOIN manager on complaints_detail.id=manager.problem_id WHERE status IN (7,10,14)";
                                                $result2 = mysqli_query($db, $sql2);
                                                $s = 1;
                                                while ($row = mysqli_fetch_array($result2)) {
                                                    $modal_id = "problem1" . $s;
                                                    $deadline_date = $row['days_to_complete']; // Assuming 'deadline' is in 'YYYY-MM-DD' format

                                                    // Get the current date
                                                    $current_date = date('Y-m-d');

                                                    // Check if the deadline is exceeded
                                                    $is_deadline_exceeded = ($current_date > $deadline_date) ? true : false;

                                                    // Apply the background color if the deadline is exceeded
                                                    $row_style = $is_deadline_exceeded ? 'background-color: rgba(255, 0, 0, 0.2);' : '';

                                                ?>
                                            <tr style="<?php echo $row_style; ?>">
                                                <td class="text-center"><?php echo $s ?></td>
                                                <td class="text-center"><?php echo $row['block_venue'] ?> /
                                                    <?php echo $row['venue_name'] ?></td>
                                                <td class="text-center">
                                                    <button type="button" value="<?php echo $row['id']; ?>"
                                                        class="btn  viewcomplaint"
                                                        data-value="<?php echo $row['fac_id']; ?>">
                                                        <i class="fas fa-eye fs-4"></i>
                                                    </button>
                                                </td>
                                                <td class="text-center"><?php echo $row['manager_approve'] ?></td>
                                                <td class="text-center"><?php echo $row['days_to_complete'] ?></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-light btn-sm showImage"
                                                        value="<?php echo $row['id']; ?>" data-bs-toggle="modal"
                                                        data-bs-target="#imageModal">
                                                        <i class="fas fa-image" style="font-size: 25px;"></i>
                                                    </button>

                                                    <button value="<?php echo $row6['id']; ?>" type="button"
                                                        class="btn btn-light btn-sm imgafter" data-bs-toggle="modal"
                                                        data-bs-target="#afterImageModal">

                                                        <i class="fas fa-images" style="font-size: 25px;"></i>
                                                    </button>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" value="<?php echo $row['task_id']; ?>" class="btn <?php
                                                                            if (!empty($row['comment_query']) && !empty($row['comment_reply'])) {
                                                                                echo 'btn-success'; // Green if both query and reply exist
                                                                            } elseif (!empty($row['comment_query']) && empty($row['comment_reply'])) {
                                                                                echo 'btn-warning'; // Yellow if only query exists
                                                                            } else {
                                                                                echo 'btn-info'; // Default blue if neither query nor reply exists
                                                                            }
                                                                            ?> details" data-bs-toggle="modal"
                                                        data-bs-target="#commentModal">
                                                        Comment
                                                    </button>
                                                </td>

                                            </tr>
                                            <!-- Add more rows as needed -->
                                            <?php
                                                    $s++;
                                                } ?>
                                            <!-- Rows for In Progress tasks -->
                                        </tbody>

                                    </table>


                                </div>



                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade p-20" id="complaints" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">


                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="Complaints" class="table table-striped table-bordered">
                                        <thead class="gradient-header">
                                            <tr>
                                                <th>S.No</th>
                                                <th>Complaint ID</th>
                                                <th>Block/Venue</th>
                                                <th>Complaint Details</th>
                                                <th>Date of Completion</th>
                                                <th>Images</th>
                                                <th>Status</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $s = 1;
                                                while ($row6 = mysqli_fetch_assoc($result6)) {
                                                ?>
                                            <tr>
                                                <td class="text-center"><?php echo $s ?></td>
                                                <td class="text-center">MKCE/WORK/<?php echo $row6['id'] ?></td>
                                                <td class="text-center">
                                                    <?php echo $row6['block_venue'] ?>/<?php echo $row6['venue_name'] ?>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" value="<?php echo $row['id']; ?>"
                                                        class="btn  viewcomplaint"
                                                        data-value="<?php echo $row['fac_id']; ?>">
                                                        <i class="fas fa-eye fs-4"></i>
                                                    </button>
                                                </td>
                                                <td class="text-center"><?php echo $row6['date_of_completion'] ?></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-light btn-sm showImage"
                                                        value="<?php echo $row['id']; ?>" data-bs-toggle="modal"
                                                        data-bs-target="#imageModal">
                                                        <i class="fas fa-image" style="font-size: 25px;"></i>
                                                    </button>

                                                    <button value="<?php echo $row6['id']; ?>" type="button"
                                                        class="btn btn-light btn-sm imgafter" data-bs-toggle="modal"
                                                        data-bs-target="#afterImageModal">

                                                        <i class="fas fa-images" style="font-size: 25px;"></i>
                                                    </button>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                            $statusMessages = [
                                                                22 => 'In Progress',
                                                                11 => 'Completed',
                                                            ];

                                                            $status = $row6['status'];
                                                            $statusMessage = $statusMessages[$status] ?? 'Unknown status';
                                                            ?>
                                                    <button type="button" class="btn btn-secondary">
                                                        <?php echo $statusMessage; ?>
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php
                                                    $s++;
                                                }
                                                ?>
                                        </tbody>

                                    </table>


                                </div>



                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade p-20" id="waitfeed" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">


                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="Waitfeedback" class="table table-striped table-bordered">
                                        <thead class="gradient-header">
                                            <tr>
                                                <th>S.No</th>
                                                <th>Problem ID</th>
                                                <th>Block/Venue</th>
                                                <th>Problem description</th>
                                                <th>Date Of submission</th>
                                                <th>Deadline</th>
                                                <th>After Image</th>
                                                <th>Worker Details</th>
                                                <th>Feedback</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $s = 1;
                                                while ($row = mysqli_fetch_assoc($result12)) {
                                                ?>
                                            <tr>
                                                <td class="text-center"><?php echo $s; ?></td>
                                                <td class="text-center"><?php echo $row['id']; ?></td>
                                                <td class="text-center"><?php echo $row['block_venue']; ?></td>
                                                <td class="text-center"><?php echo $row['problem_description']; ?></td>
                                                <td class="text-center"><?php echo $row['date_of_reg']; ?></td>
                                                <td class="text-center">
                                                    <?php if ($row['extend_date'] == 1) { ?>
                                                    <button type="button" class="btn btn-danger extenddeadline"
                                                        id="extendbutton" value="<?php echo $row['id']; ?>"
                                                        data-toggle="modal" data-target="#extendModal"
                                                        data-reason="<?php echo $row['extend_reason']; ?>">
                                                        <?php echo $row['days_to_complete']; ?>
                                                    </button>
                                                    <?php } else { ?>
                                                    <?php echo $row['days_to_complete']; ?>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center">
                                                    <button value="<?php echo $row6['id']; ?>" type="button"
                                                        class="btn btn-light btn-sm imgafter" data-bs-toggle="modal"
                                                        data-bs-target="#afterImageModal">

                                                        <i class="fas fa-images" style="font-size: 25px;"></i>
                                                    </button>
                                                </td>


                                                <td class="text-center">
                                                    <button type="button" class="btn btn-light showWorkerDetails"
                                                        value="<?php echo $row['id']; ?>">
                                                        <?php
                                                                $prblm_id = $row['id'];
                                                                $querry = "SELECT worker_first_name FROM worker_details WHERE worker_id = ( SELECT worker_dept FROM manager WHERE problem_id = '$prblm_id')";
                                                                $querry_run = mysqli_query($db, $querry);
                                                                $worker_name = mysqli_fetch_array($querry_run);
                                                                if ($worker_name['worker_first_name'] != null) {
                                                                    echo $worker_name['worker_first_name'];
                                                                } else {
                                                                    echo "NA";
                                                                }
                                                                ?>
                                                    </button>
                                                </td>
                                                <td class="text-center">

                                                    <?php
                                                            if ($row['status'] == 14) {
                                                            ?>
                                                    <button class="btn btn-success">Submitted</button>

                                                    <?php
                                                            } else {
                                                            ?>
                                                    <!-- Button to open the feedback modal -->
                                                    <button type="button" class="btn btn-info feedbackBtn"
                                                        data-problem-id="<?php echo $row['id']; ?>" data-toggle="modal"
                                                        data-target="#feedback_modal">Feedback</button>

                                                    <?php
                                                            }
                                                            ?>

                                                </td>
                                            </tr>
                                            <?php
                                                    $s++;
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

    <!-- Footer -->
    <?php include 'footer.php'; ?>
    </div>

    <!--Description id=problem-->
    <!-- Problem Description Modal -->
    <!-- Comment Modal -->
    <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentModalLabel">Comment Forum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="comment_det">
                    <div class="modal-body">
                        <input type="hidden" name="task_id" id="task_id">

                        <!-- Query Field -->
                        <label class="form-label">Query*</label>
                        <input type="text" class="form-control" id="comment_query" name="comment_query"
                            placeholder="Enter your query here">
                        <input type="text" class="form-control" id="query_date" name="query_date"
                            placeholder="Date of Query Submission">

                        <!-- Reply Field -->
                        <label class="form-label">Reply*</label>
                        <input type="text" class="form-control" id="comment_reply" name="comment_reply"
                            placeholder="Reply will be displayed here" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"
                    style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Problem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="rejectreason">
                    <div class="modal-body">
                        <p>Are you sure you want to reject this problem?</p>
                        <textarea name="reason" class="form-control" placeholder="Reason for rejection"
                            required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Worker Details Modal -->
    <div class="modal fade" id="workerModal" tabindex="-1" aria-labelledby="workerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"
                    style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);">
                    <h5 class="modal-title" id="workerModalLabel">Worker Phone</h5>
                    <button class="spbutton btn-close" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="box"
                        style="background-color: #f7f7f7; border: 1px solid #ccc; padding: 15px; margin-bottom: 10px; border-radius: 5px;">
                        <p><strong>Contact:</strong> <span id="workerContact">Not Available</span></p>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a id="callWorkerBtn" class="btn btn-success" href="tel:">Call Worker</a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Before Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" alt="Image" class="img-fluid" style="width: 100%; height: auto;">
                    <!-- src will be set dynamically -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Complaint Details Modal -->
    <div class="modal fade" id="complaintDetailsModal" tabindex="-1" role="dialog"
        aria-labelledby="complaintDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content"
                style="border-radius: 8px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15); background-color: #f9f9f9;">

                <!-- Modal Header -->
                <div class="modal-header"
                    style="background-color: #007bff; color: white; border-radius: 8px 8px 0 0; padding: 15px;">
                    <h5 class="modal-title" id="complaintDetailsModalLabel"
                        style="font-weight: 700; font-size: 1.4em; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                        📋 Complaint Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body"
                    style="padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold text-primary">Complaint ID</label>
                            <div class="text-muted"><b id="id"></b></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold text-primary">Faculty Infra Coordinator Name</label>
                            <div class="text-muted"><b id="faculty_name"></b></div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold text-primary">Mobile Number</label>
                            <div class="text-muted"><b id="faculty_contact"></b></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold text-primary">E-mail</label>
                            <div class="text-muted"><b id="faculty_mail"></b></div>
                        </div>

                        <!-- Venue & Type of Problem -->
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold text-primary">Venue Name</label>
                            <div class="text-muted"><b id="venue_name"></b></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold text-primary">Type of Problem</label>
                            <div class="text-muted"><b id="type_of_problem"></b></div>
                        </div>

                        <!-- Problem Description -->
                        <div class="col-md-12">
                            <label class="fw-bold text-primary">Problem Description</label>
                            <div class="alert alert-light" role="alert"
                                style="border-radius: 6px; background-color: #f1f1f1; padding: 15px; color: #333;">
                                <span id="problem_description"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer" style="background-color: #f1f1f1; border-radius: 0 0 8px 8px;">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!------------------Pending Work Modal----------------->
    <div class="tab-pane p-20" id="home" role="tabpanel">
        <div class="modal fade" id="cmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"
                        style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);background-color:#7460ee;">
                        <h5 class="modal-title" id="exampleModalLabel">Raise Complaint</h5>
                        <button class="spbutton" type="button" class="btn-close" data-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div>
                        <form id="addnewuser" enctype="multipart/form-data" onsubmit="handleSubmit(event)">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <input type="hidden" id="hidden_faculty_id" name="faculty_id"
                                        value="<?php echo $faculty_id; ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="type_of_problem" class="form-label">Type of Problem <span
                                            style="color: red;">*</span></label>
                                    <select class="form-control" name="type_of_problem"
                                        style="width: 100%; height:36px;">
                                        <option>Select</option>
                                        <option value="elecrtical">ELECTRICAL</option>
                                        <option value="civil">CIVIL</option>
                                        <option value="itkm">ITKM </option>
                                        <option value="transport">TRANSPORT</option>
                                        <option value="house">HOUSE KEEPING </option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="block" class="form-label">Block <span
                                            style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="block_venue"
                                        placeholder="Eg:RK-206 / Transport:Bus No" required>
                                </div>
                                <div class="mb-3">
                                    <label for="venue" class="form-label">Venue <span
                                            style="color: red;">*</span></label>
                                    <select id="dropdown" class="form-control" name="venue_name"
                                        onchange="checkIfOthers()" style="width: 100%; height:36px;">
                                        <option>Select</option>
                                        <option value="class">Class Room</option>
                                        <option value="department">Department</option>
                                        <option value="lab">Lab</option>
                                        <option value="staff_room">Staff Room</option>
                                        <option id="oth" value="Other">Others</option>
                                    </select>
                                </div>

                                <div id="othersInput" style="display: none;">
                                    <label class="form-label" for="otherValue">Please specify: <span
                                            style="color: red;">*</span></label>
                                    <input class="form-control" type="text" id="otherValue" name="otherValue"> <br>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Problem Description <span
                                            style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="problem_description"
                                        placeholder="Enter Description" required>
                                </div>

                                <div class="mb-3">
                                    <label for="itemno" class="form-label">Item Number(for electrical/itkm work)</label>
                                    <input type="text" class="form-control" name="itemno" placeholder="Eg: AC-102">
                                </div>
                                <div class="mb-3">
                                    <label for="images" class="form-label">Image(less than 2mb)<span
                                            style="color: red;">*</span> </label>
                                    <input type="file" class="form-control" name="images" id="images"
                                        onchange="validateSize(this)" required>
                                </div>
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" name="date_of_reg" id="date_of_reg"
                                        required>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- After Image Modal -->
    <div class="modal fade" id="afterImageModal" tabindex="-1" aria-labelledby="afterImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="afterImageModalLabel">After Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage2" src="" alt="After" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
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

    document.addEventListener("DOMContentLoaded", function() {
        // Cache DOM elements
        const elements = {
            hamburger: document.getElementById('hamburger'),
            sidebar: document.getElementById('sidebar'),
            mobileOverlay: document.getElementById('mobileOverlay'),
            menuItems: document.querySelectorAll('.menu-item'),
            submenuItems: document.querySelectorAll('.submenu-item') // Add submenu items to cache
        };

        // Set active menu item based on current path
        function setActiveMenuItem() {
            const currentPath = window.location.pathname.split('/').pop();

            // Clear all active states first
            elements.menuItems.forEach(item => item.classList.remove('active'));
            elements.submenuItems.forEach(item => item.classList.remove('active'));

            // Check main menu items
            elements.menuItems.forEach(item => {
                const itemPath = item.getAttribute('href')?.replace('/', '');
                if (itemPath === currentPath) {
                    item.classList.add('active');
                    // If this item has a parent submenu, activate it too
                    const parentSubmenu = item.closest('.submenu');
                    const parentMenuItem = parentSubmenu?.previousElementSibling;
                    if (parentSubmenu && parentMenuItem) {
                        parentSubmenu.classList.add('active');
                        parentMenuItem.classList.add('active');
                    }
                }
            });

            // Check submenu items
            elements.submenuItems.forEach(item => {
                const itemPath = item.getAttribute('href')?.replace('/', '');
                if (itemPath === currentPath) {
                    item.classList.add('active');
                    // Activate parent submenu and its trigger
                    const parentSubmenu = item.closest('.submenu');
                    const parentMenuItem = parentSubmenu?.previousElementSibling;
                    if (parentSubmenu && parentMenuItem) {
                        parentSubmenu.classList.add('active');
                        parentMenuItem.classList.add('active');
                    }
                }
            });
        }

        // Handle mobile sidebar toggle
        function handleSidebarToggle() {
            if (window.innerWidth <= 768) {
                elements.sidebar.classList.toggle('mobile-show');
                elements.mobileOverlay.classList.toggle('show');
                document.body.classList.toggle('sidebar-open');
            } else {
                elements.sidebar.classList.toggle('collapsed');
            }
        }

        // Handle window resize
        function handleResize() {
            if (window.innerWidth <= 768) {
                elements.sidebar.classList.remove('collapsed');
                elements.sidebar.classList.remove('mobile-show');
                elements.mobileOverlay.classList.remove('show');
                document.body.classList.remove('sidebar-open');
            } else {
                elements.sidebar.style.transform = '';
                elements.mobileOverlay.classList.remove('show');
                document.body.classList.remove('sidebar-open');
            }
        }

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

        // Enhanced Toggle Submenu with active state handling
        const menuItems = document.querySelectorAll('.has-submenu');
        menuItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault(); // Prevent default if it's a link
                const submenu = item.nextElementSibling;

                // Toggle active state for the clicked menu item and its submenu
                item.classList.toggle('active');
                submenu.classList.toggle('active');

                // Handle submenu item clicks
                const submenuItems = submenu.querySelectorAll('.submenu-item');
                submenuItems.forEach(submenuItem => {
                    submenuItem.addEventListener('click', (e) => {
                        // Remove active class from all submenu items
                        submenuItems.forEach(si => si.classList.remove(
                            'active'));
                        // Add active class to clicked submenu item
                        submenuItem.classList.add('active');
                        e.stopPropagation(); // Prevent event from bubbling up
                    });
                });
            });
        });

        // Initialize event listeners
        function initializeEventListeners() {
            // Sidebar toggle for mobile and desktop
            if (elements.hamburger && elements.mobileOverlay) {
                elements.hamburger.addEventListener('click', handleSidebarToggle);
                elements.mobileOverlay.addEventListener('click', handleSidebarToggle);
            }
            // Window resize handler
            window.addEventListener('resize', handleResize);
        }

        // Initialize everything
        setActiveMenuItem();
        initializeEventListeners();
    });
    </script>
    <!-- Set Today date in Raise Complaint-->
    <script>
    var today = new Date().toISOString().split('T')[0];
    var dateInput = document.getElementById('date_of_reg');
    dateInput.setAttribute('min', today);
    dateInput.setAttribute('max', today);
    dateInput.value = today;

    $(document).ready(function() {
        $('#Requirements').DataTable();
        $('#Completeds').DataTable();
        $('#Inprogress').DataTable();
        $('#Complaints').DataTable();
        $('#Waitfeedback').DataTable();



    });
    </script>














    <!--file size and type -->
    <script>
    function validateSize(input) {
        const filesize = input.files[0].size / 1024; // Size in KB
        var ext = input.value.split(".");
        ext = ext[ext.length - 1].toLowerCase();
        var arrayExtensions = ["jpg", "jpeg", "png"];
        if (arrayExtensions.lastIndexOf(ext) == -1) {
            swal("Invalid Image Format, Only .jpeg, .jpg, .png format allowed", "", "error");
            $(input).val('');
        } else if (filesize > 2048) {
            swal("File is too large, Maximum 2 MB is allowed", "", "error");
            $(input).val('');
        }
    }

    //raise complaint others field
    function checkIfOthers() {
        const dropdown = document.getElementById('dropdown');
        const othersInput = document.getElementById('othersInput');

        // Show the input field if "Others" is selected
        if (dropdown.value === 'Other') {
            othersInput.style.display = 'block';
        } else {
            othersInput.style.display = 'none';
        }
    }

    function handleSubmit(event) {
        event.preventDefault(); // Prevent form submission for demo purposes
        const dropdown = document.getElementById('dropdown');
        const selectedValue = dropdown.value;
        let finalValue;

        // Get the appropriate value based on the dropdown selection
        if (selectedValue === 'Other') {
            finalValue = document.getElementById('otherValue').value;
        } else {
            finalValue = selectedValue;
        }

        console.log("Selected Category:", finalValue);
        // You can then send this data to the backend or process it further
        $("#oth").val(finalValue);
    }
    </script>

    <script>
    $(document).ready(function() {
        $('#addnewtask').DataTable();
    });

    // Add Faculty complaints to database
    $(document).on('submit', '#addnewuser', function(e) {
        e.preventDefault(); // Prevent form from submitting normally
        var formData = new FormData(this);
        formData.append("hod", true);
        $.ajax({
            type: "POST",
            url: 'cms_backend.php?action=addpcomplaint',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var res = typeof response === 'string' ? JSON.parse(response) : response;
                if (res.status === 200) {
                    swal("Complaint Submitted!", "", "success");
                    $('#raisemodal').modal('hide');
                    $('#addnewuser')[0].reset(); // Reset the form
                    $('#user').DataTable().destroy();
                    $("#user").load(location.href + " #user > *", function() {
                        $('#user').DataTable();
                    });
                } else {
                    console.error("Error:", res.message);
                    alert("Something went wrong! Try again.");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                alert("Failed to process response. Please try again.");
            }
        });
    });

    //requirement approve
    $(document).on('click', '.userapprove', function(e) {
        e.preventDefault();
        var user_id = $(this).val();
        console.log(user_id);
        if (confirm('Are you sure you want to approve?')) {

            $.ajax({
                type: "POST",
                url: 'cms_backend.php?action=approve_user',
                data: {
                    'user_id': user_id
                },
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 500) {
                        alert(res.message);
                    } else {
                        Swal.fire({
                            title: "Approved!",
                            text: "Requirements are verified!",
                            icon: "success"
                        });
                        $('#addnewtask').load(location.href + " #addnewtask");
                        $('#addnewtask').DataTable().destroy();

                        $("#addnewtask").load(location.href + " #addnewtask > *", function() {
                            // Reinitialize the DataTable after the content is loaded
                            $('#addnewtask').DataTable();
                        });
                    }
                }
            });
        }
    });

    //reject 
    $(document).on("click", ".userreject", function(e) {
        e.preventDefault();
        var id = $(this).val();
        console.log("haii:", id);
        $(document).data("user_id", id);
    });
    $(document).on('submit', '#rejectreason', function(e) {
        e.preventDefault(); // Prevent default form submission
        // Create a FormData object from the form
        var formData = new FormData(this);
        var user_id = $(document).data("user_id")
        // Append the problem_id to the FormData
        formData.append("problem_id", user_id);

        // Perform the AJAX request
        $.ajax({
            type: "POST",
            url: 'cms_backend.php?action=reject_user', // Replace with your backend PHP script
            data: formData,
            processData: false, // Important: Prevent jQuery from processing the data
            contentType: false, // Important: Prevent jQuery from setting the content type
            success: function(response) {
                console.log(response);
                var res = jQuery.parseJSON(response);

                if (res.status == 200) {
                    // Hide the modal on success

                    $('#rejectModal').modal('hide');

                    // Reset the form after submission
                    $('#rejectreason')[0].reset();
                    // Reload the task or the section after update

                    $('#addnewtask').load(location.href + " #addnewtask");
                    $('#addnewtask').DataTable().destroy();

                    $("#addnewtask").load(location.href + " #addnewtask > *", function() {
                        // Reinitialize the DataTable after the content is loaded
                        $('#addnewtask').DataTable();
                    });
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.error('Rejected Success');
                } else {
                    // Handle errors
                    alertify.error('Error Occured');
                }
            },
            error: function(xhr, status, error) {
                // Handle any errors that occurred during the request
                console.error('AJAX Error:', error);
                alert('An error occurred. Please try again.');
            }
        });
    });

    // Pass the problem_id to the modal when it is shown
    $('#rejectModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var problem_id = button.val(); // Extract problem_id from button value
        var modal = $(this);
        modal.data('problem_id', problem_id); // Store problem_id in the modal's data attribute
    });

    //Before image
    $(document).on("click", ".showImage", function() {
        var problem_id = $(this).val(); // Get the problem_id from button value
        console.log(problem_id); // Ensure this logs correctly
        $.ajax({
            type: "POST",
            url: 'cms_backend.php?action=get_image',
            data: {
                problem_id: problem_id, // Correct POST key
            },
            dataType: "json", // Automatically parses JSON responses
            success: function(response) {
                console.log(response); // Log the parsed JSON response
                if (response.status == 200) {
                    // Dynamically set the image source
                    $("#modalImage").attr("src", "uploads/" + response.data.images);
                    // Show the modal
                    $("#imageModal").modal("show");
                } else {
                    // Handle case where no image is found
                    alert(
                        response.message || "An error occurred while retrieving the image."
                    );
                }
            },
            error: function(xhr, status, error) {
                // Log the full error details for debugging
                console.error("AJAX Error: ", xhr.responseText);
                alert(
                    "An error occurred: " +
                    error +
                    "\nStatus: " +
                    status +
                    "\nDetails: " +
                    xhr.responseText
                );
            },
        });
    });

    function checkIfOthers() {
        const dropdown = document.getElementById('dropdown');
        const othersInput = document.getElementById('othersInput');

        // Show the input field if "Others" is selected
        if (dropdown.value === 'Other') {
            othersInput.style.display = 'block';
        } else {
            othersInput.style.display = 'none';
        }
    }

    function handleSubmit(event) {
        event.preventDefault(); // Prevent form submission for demo purposes
        const dropdown = document.getElementById('dropdown');
        const selectedValue = dropdown.value;
        let finalValue;

        // Get the appropriate value based on the dropdown selection
        if (selectedValue === 'Other') {
            finalValue = document.getElementById('otherValue').value;
        } else {
            finalValue = selectedValue;
        }

        console.log("Selected Category:", finalValue);
        // You can then send this data to the backend or process it further
        $("#oth").val(finalValue);
    }

    //to shows table
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });

    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#dataTable1').DataTable();

        // Apply filter on status change
        $('#status-filter').on('change', function() {
            var selectedStatus = $(this).val();
            if (selectedStatus) {
                table.column(8).search('^' + selectedStatus + '$', true, false).draw();
            } else {
                table.column(8).search('').draw();
            }
        });
    });

    $(document).ready(function() {
        $('#dataTable2').DataTable();
    });
    //comments query to insert

    $(document).on('click', '.details', function(e) {
        e.preventDefault();
        if ($(this).prop('disabled')) {
            return; // Prevent modal from opening if the button is disabled
        }
        var user_id = $(this).val();
        console.log(user_id)
        $.ajax({
            type: "POST",
            url: 'cms_backend.php?action=manager_response',
            data: {
                'user_id': user_id
            },
            success: function(response) {

                var res = jQuery.parseJSON(response);
                console.log(res);
                if (res.status == 500) {
                    alert(res.message);
                } else {
                    //$('#student_id2').val(res.data.uid);

                    $('#task_id').val(res.data.task_id);
                    $('#comment_query').val(res.data.comment_query);
                    $('#comment_reply').val(res.data.comment_reply);

                    $('#query_date').val("Query Submission Date: " + res.data.query_date);
                    var queryReadOnly = res.date_diff < 5 && res.data.comment_query;
                    if (queryReadOnly) {
                        // If less than 5 days and comment_query is given, make it readonly
                        $('#comment_query').prop('readonly', true);
                    } else {
                        // Otherwise, make it editable
                        $('#comment_query').prop('readonly', false);
                    }
                    $('#comment').modal('show');
                }
            }
        });
    });

    $(document).on('submit', '#comment_det', function(e) {
        e.preventDefault();
        var queryReadOnly = $('#comment_query').prop('readonly');
        var comment_query = $('#comment_query').val();
        var comment_reply = $('#comment_reply').val();

        // If both fields are readonly, simply close the modal without submitting
        if (queryReadOnly) {
            $('#comment').modal('hide');
        } else {
            var formData = new FormData(this);
            console.log(formData)
            $.ajax({
                type: "POST",
                url: 'cms_backend.php?action=principal_query',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    var res = jQuery.parseJSON(response);
                    if (res.status == 200) {
                        $('#comment').modal('hide');
                        $('#comment_det')[0].reset();
                        $('#dataTable1').load(location.href + " #dataTable1");
                        alertify.success('Query Successfully Submitted');

                    } else if (res.status == 500) {
                        $('#comment').modal('hide');
                        $('#comment_det')[0].reset();
                        console.error("Error:", res.message);
                        alert("Something Went wrong.! try again")
                    }
                }
            });
        }
    });

    //after image
    $(document).on("click", ".imgafter", function() {
        var problem_id = $(this).val(); // Get the problem_id from button value
        console.log(problem_id); // Ensure this logs correctly
        $.ajax({
            type: "POST",
            url: 'cms_backend.php?action=get_aimage',
            data: {
                problem2_id: problem_id, // Correct POST key
            },
            dataType: "json", // Automatically parses JSON responses
            success: function(response) {
                console.log(response); // Log the parsed JSON response
                if (response.status == 200) { // Use 'response' instead of 'res'
                    // Dynamically set the image source
                    $("#modalImage2").attr("src", response.data.after_photo);
                    // Show the modal
                    $("#afterImageModal").modal("show");
                } else {
                    // Handle case where no image is found
                    alert(response.message || "An error occurred while retrieving the image.");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", status, error);
            }
        });
    });
    $('#afterImageModal').on('hidden.bs.modal', function() {
        // Reset the image source to a default or blank placeholder
        $("#modalImage2").attr("src", "path/to/placeholder_image.jpg");
    });



    $(document).ready(function() {
        $("#completed_table").DataTable();
    });



    //jquerry for view complaint
    $(document).on("click", ".viewcomplaint", function(e) {
        e.preventDefault();
        var user_id = $(this).val();
        var fac_id = $(".viewcomplaint").data("value");
        console.log(user_id);
        console.log(fac_id);
        $.ajax({
            type: "POST",
            url: 'cms_backend.php?action=view_complaint',
            data: {
                user_id: user_id,
                fac_id: fac_id,
            },
            success: function(response) {
                console.log(response);
                var res = jQuery.parseJSON(response);
                console.log(res);
                if (res.status == 404) {
                    alert(res.message);
                } else {
                    //$('#student_id2').val(res.data.uid);
                    $("#id").text(res.data.id);
                    $("#type_of_problem").text(res.data.type_of_problem);
                    $("#problem_description").text(res.data.problem_description);
                    if (res.data.faculty_name) {
                        $("#faculty_name").text(res.data.faculty_name);


                    } else {
                        $("#faculty_name").text("N/A");


                    }
                    if (res.data.faculty_mail) {
                        $("#faculty_mail").text(res.data.faculty_mail);


                    } else {
                        $("#faculty_mail").text("N/A");


                    }
                    if (res.data.faculty_contact) {
                        $("#faculty_contact").text(res.data.faculty_contact);


                    } else {
                        $("#faculty_contact").text("N/A");

                    }

                    $("#block_venue").text(res.data.block_venue);
                    $("#venue_name").text(res.data.venue_name);
                    if (res.data1) {


                        $("#fac_name").text(res.data1.name);
                        $("#fac_id").text(res.data1.id);
                    } else {
                        $("#fac_name").text("N/A");
                        $("#fac_id").text("N/A");

                    }
                    $("#complaintDetailsModal").modal("show");
                }
            },
        });
    });


    // Add Faculty complaints to database
    $(document).on('submit', '#addnewuser', function(e) {
        e.preventDefault(); // Prevent form from submitting normally
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: 'cms_backend.php?action=princraisecomp',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var res = jQuery.parseJSON(response);
                if (res.status === 200) {
                    swal("Complaint Submitted!", "", "success");
                    $('#cmodal').modal('hide');
                    $('#addnewuser')[0].reset(); // Reset the form
                    $('#navref1').load(location.href + " #navref1");
                    $('#navref2').load(location.href + " #navref2");
                    $('#navref3').load(location.href + " #navref3");
                    $('#dashref').load(location.href + " #dashref");
                    $('#raise_complaint').load(location.href + " #raise_complaint");
                    $('#complaints_table').load(location.href + " #complaints_table");

                    $('#user').DataTable().destroy();
                    $("#user").load(location.href + " #user > *", function() {
                        $('#user').DataTable();
                    });
                } else {
                    console.error("Error:", res.message);
                    alert("Something went wrong! Try again.");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                alert("Failed to process response. Please try again.");
            }
        });
    });

    //Star Rating Coding
    const stars = document.querySelectorAll("#star-rating span");
    const ratingValue = document.getElementById("rating-value");
    const ratevalue = document.getElementById("ratevalue");



    stars.forEach((star, index) => {
        star.addEventListener("click", () => {
            // Remove the "highlighted" class from all stars hidhlited is used in Style
            stars.forEach(s => s.classList.remove("highlighted"));

            // Add the "highlighted" class to all stars up to the clicked one
            for (let i = 0; i <= index; i++) {
                stars[i].classList.add("highlighted");
            }

            // Update the rating value
            ratingValue.textContent = `Rating: ${index + 1}`;
            ratevalue.textContent = `${index + 1}`;
            var rating = ratevalue.textContent;
            $(document).data("ratings", rating);
        });
    });

    // Open feedback modal and set id
    $(document).on('click', '.feedbackBtn', function() {
        var id = $(this).data('problem-id');
        // Clear the feedback field and dropdown before opening the modal
        $('#feedback').val('');
        $('#satisfaction').val('');
        $('#feedback_id').val(id);
        $('#feedback_modal').modal('show');
    });
    // Handle feedback form submission
    $('#add_feedback').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        var formData = new FormData(this);
        console.log(formData);

        // Get the values of satisfaction and feedback
        var satisfactionValue = $('#satisfaction').val();
        var feedbackValue = $('#feedback').val();
        console.log(satisfactionValue);
        console.log(feedbackValue);

        // Combine satisfaction and feedback into a single value
        var combinedFeedback = satisfactionValue + ": " + feedbackValue;
        formData.append("satisfaction_feedback", combinedFeedback);

        var store_rating = $(document).data("ratings");
        console.log(store_rating);

        formData.append("ratings", store_rating);
        $.ajax({
            type: "POST",
            url: 'cms_backend.php?action=facdetfeedback',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                var res = jQuery.parseJSON(response);
                if (res.status == 200) {
                    swal("Done!", "Feedback Submitted!", "success");
                    $("#add_feedback")[0].reset();
                    $('#feedback_modal').modal('hide');
                    $('.modal-backdrop').remove(); // Remove lingering backdrop




                    $('#addnewtask').DataTable().destroy();
                    $("#addnewtask").load(location.href + " #addnewtask > *", function() {
                        $('#addnewtask').DataTable();
                    });

                    $('#completed_table').DataTable().destroy();
                    $("#completed_table").load(location.href + " #completed_table > *", function() {
                        $('#completed_table').DataTable();
                    });

                    $('#dataTable1').DataTable().destroy();
                    $("#dataTable1").load(location.href + " #dataTable1 > *", function() {
                        $('#dataTable1').DataTable();
                    });

                    $('#feedbackTable').DataTable().destroy();
                    $("#feedbackTable").load(location.href + " #feedbackTable > *", function() {
                        $('#feedbackTable').DataTable();
                    });
                    $('#complaints_table').DataTable().destroy();
                    $("#complaints_table").load(location.href + " #complaints_table > *",
                function() {
                        $('#complaints_table').DataTable();
                    });
                } else {
                    alert(response.message || 'An error occurred while submitting feedback.');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", xhr.responseText);
                alert('An error occurred while submitting feedback: ' + error);
            }
        });
    });

    // Display worker details in work in progress
    $(document).on('click', '.showWorkerDetails', function() {
        var id = $(this).val(); // Get the id from the button value
        console.log("Fetching worker details for id: " + id); // Debug log
        $.ajax({
            type: "POST",
            url: 'cms_backend.php?action=facworkerdet',
            data: {
                'id': id
            },
            dataType: "json",
            success: function(response) {
                if (response.status == 200) {
                    $('#workerName').text(response.worker_first_name);
                    $('#workerContact').text(response.worker_mobile);
                    $('#callWorkerBtn').attr('href', 'tel:' + response.worker_mobile);
                    $('#workerModal').modal('show');
                } else {
                    alert(response.message || 'No worker details found.');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", xhr.responseText);
                alert('An error occurred while fetching the worker details: ' + error);
            }
        });
    });
    </script>

</body>

</html>