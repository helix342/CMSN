<?php
require 'config.php';
include("session.php");

$hod_id =  $fac_id;

$role = $frole;
if($role!=="HOD"){
    header("Location:index.php");

}
$hdept = "SELECT * FROM faculty WHERE id='$hod_id'";
$hdept_run = mysqli_query($db, $hdept);
$hdept_data = mysqli_fetch_array($hdept_run);
$dept = $hdept_data['dept'];
$sql = "
SELECT cd.*, f.name, f.dept
FROM complaints_detail cd
JOIN faculty f ON cd.faculty_id = f.id
WHERE cd.status = '2'AND f.dept = '$dept'
";
$sql1 = "
SELECT cd.*, f.name, f.dept
FROM complaints_detail cd
JOIN faculty f ON cd.faculty_id = f.id
WHERE cd.status IN (4, 6, 7, 10, 11, 13, 14, 15, 17, 18, 22) AND f.dept = '$dept'
";
$sql2 = "
SELECT cd.*, f.name, f.dept
FROM complaints_detail cd
JOIN faculty f ON cd.faculty_id = f.id
WHERE cd.status = '16' AND f.dept = '$dept'
";
$sql3 = "
SELECT cd.*, f.name, f.dept
FROM complaints_detail cd
JOIN faculty f ON cd.faculty_id = f.id
WHERE cd.status IN (19, 20, 23) AND f.dept = '$dept'
";
$result = mysqli_query($db, $sql);
$pending = mysqli_num_rows($result);
$result1 = mysqli_query($db, $sql1);
$approved = mysqli_num_rows($result1);
$result2 = mysqli_query($db, $sql2);
$completed = mysqli_num_rows($result2);
$result3 = mysqli_query($db, $sql3);
$rejected = mysqli_num_rows($result3);

$sql11 ="SELECT * FROM complaints_detail WHERE status IN (11,18,14) AND faculty_id = '$hod_id'";
$result11 = mysqli_query($db, $sql11);
$row_count11 = mysqli_num_rows($result11);


?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>MIC-MKCE</title>
    <!-- Custom CSS -->
    <link href="assets/libs/flot/css/float-chart.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <link href="css/dboardstyles.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>

    <style>
        .table-container {
            -ms-overflow-style: none;
        }

        .table-container {
            overflow: auto;
            width: 100%;
            height: 100%;

        }

        .fixed-size-table {
            width: 100%;
            table-layout: fixed;
        }

        .fixed-size-table th,
        .fixed-size-table td {
            width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nav-tabs .nav-link {
            color: #0033cc;
        }

        .nav-tabs .nav-link.active {
            background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
            color: white;
        }

        .modal-content {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            border-radius: 15px 15px 0px 0px;
        }

        .modal-header .close {
            font-size: 1.5rem;
            color: white;
            opacity: 1;
            transition: transform 0.3s ease;
        }

        .modal-header .close:hover {
            transform: rotate(90deg);
            color: #ff8080;
        }
        /*star rating*/
        .stars span {
            font-size: 2rem;
            cursor: pointer;
            color: gray;
            /* Default color for unlit stars */
            transition: color 0.3s;
        }

        .stars span.highlighted {
            color: gold;
            /* Color for lit stars */
        }
    </style>

</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper">
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="smain">
                        <!-- Logo icon -->

                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="assets/images/srms33333.png" alt="homepage" class="light-logo" />

                        </span>
                        <!-- Logo icon -->
                        <!-- <b class="logo-icon"> -->
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <!-- <img src="assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->

                        <!-- </b> -->
                        <!--End Logo icon -->
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ti-more"></i></a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a
                                class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    src="assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <a class="dropdown-item" href="Logout"><i
                                        class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                                <div class="dropdown-divider"></div>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php

        include("side.php");

        ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Feedback Approval</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="hod.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Feedback Corner</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <form class="zmdi-format-valign-top">
                                <div class="card-body">
                                    <h4 class="card-title">Complaint Details</h4>
                                    <div class="card">
                                        <ul class="nav nav-tabs mb-3" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active show" data-toggle="tab" href="#dashboard"
                                                    role="tab" aria-selected="true"><span class="hidden-sm-up"></span>
                                                    <span class="hidden-xs-down"><i
                                                            class="mdi mdi-view-grid"></i><b>&nbsp Dashboard</b></span></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#pending"
                                                    role="tab" aria-selected="false"><span class="hidden-sm-up"></span>
                                                    <div id="navref1">
                                                        <span class="hidden-xs-down">
                                                            <i class="fas fa-clock"></i>
                                                            <b>&nbsp Pending (<?php echo $pending; ?>) </b>
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#approved" role="tab"
                                                    aria-selected="false"><span class="hidden-sm-up"></span>
                                                    <div id="navref2">
                                                        <span class="hidden-xs-down">
                                                            <i class="fas fa-check"></i><b>&nbsp Approved (<?php echo $approved;
                                                                                                            ?>)</b>
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#completed" role="tab"
                                                    aria-selected="false"><span class="hidden-sm-up"></span>
                                                    <div id="navref3">
                                                        <span class="hidden-xs-down">
                                                            <i class="mdi mdi-check-all"></i><b>&nbsp Completed (<?php echo $completed;
                                                                                                                    ?>)</b>
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#rejected" role="tab"
                                                    aria-selected="false"><span class="hidden-sm-up"></span>
                                                    <div id="navref4">
                                                        <span class="hidden-xs-down">
                                                            <i class="mdi mdi-close-circle"></i><b>&nbsp Rejected (<?php echo $rejected;
                                                                                                                    ?>)</b>
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="nav-item">

                                        <a class="nav-link" data-toggle="tab" href="#waitfeed" role="tab" aria-selected="false">
                                            <span class="hidden-sm-up"></span>
                                            <div id="navref33">
                                                <span class="hidden-xs-down">
                                                    <i class="bi bi-people-fill"></i>
                                                    <i class="fas fa-clock"></i>
                                                    <b>&nbsp Feedback (<?php echo $row_count11; ?>)</b>
                                                </span>
                                            </div>
                                        </a>

                                    </li>
                                        </ul>
                                        <!-------------------------dashboard------------------------------>
                                        <div class="tab-content tabcontent-border">
                                            <div class="tab-pane p-20 active show" id="dashboard" role="tabpanel">
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
                                                                                    <?php echo $pending;
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
                                                                                    <?php echo $approved;
                                                                                    ?>
                                                                                </h1>
                                                                                <small class="font-light">Approved</small>
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
                                                                                <i class="mdi mdi-check-all"></i>
                                                                                <h1 class="font-light text-white">
                                                                                    <?php echo $completed;
                                                                                    ?>
                                                                                </h1>
                                                                                <small class="font-light">Completed</small>
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
                                                                                <i class="fas fa-exclamation"></i>
                                                                                <h1 class="font-light text-white">
                                                                                    <?php echo $rejected;
                                                                                    ?>
                                                                                </h1>
                                                                                <small class="font-light">Rejected</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-------------------------pending tab---------------------------->
                                            <div class="tab-pane p-20" id="pending" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4>
                                                                    Raise Complaint
                                                                    <button type="button" class="btn btn-info float-right fac" data-toggle="modal" data-target="#raisemodal">Raise Compliant</button>
                                                                    <br>
                                                                </h4>
                                                            </div>



                                                            <div class="card-body">
                                                                <div class="table-container">
                                                                    <table id="myTable1" class="table table-bordered table-striped fixed-size-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="pending status text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white; width: 40px;">
                                                                                    <b>S.No</b>
                                                                                </th>
                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white; width: 80px;">
                                                                                    <b>Date Registered</b>
                                                                                </th>
                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white; width: 70px;">
                                                                                    <b>Faculty Name</b>
                                                                                </th>
                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                                                    <b>Problem Description</b>
                                                                                </th>
                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                                                    <b>Image</b>
                                                                                </th>

                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                                                    <b>Forwarded Reason</b>
                                                                                </th>

                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                                                    <b>Action</b>
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $id = 1;
                                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                            ?>
                                                                                <tr>
                                                                                    <td class="text-center">
                                                                                        <?php echo $id; ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <?php echo $row['date_of_reg']; ?>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <button type="button"
                                                                                                class="btn btn-link faculty" id="facultyinfo"
                                                                                                data-value="<?php echo $row['fac_id']; ?>"
                                                                                                data-toggle="modal" value="<?php echo $row['id']; ?>"
                                                                                                data-target="#facultymodal" style="text-decoration:none;"><?php echo $row['name']; ?>
                                                                                            </button>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <button type="button"
                                                                                                data-problemid
                                                                                                class="btn btndesc" id="seeproblem"
                                                                                                data-toggle="modal" value='<?php echo $row['id']; ?>'
                                                                                                data-target="#probdesc">
                                                                                                <i class="fas fa-solid fa-eye" style="font-size: 20px;"></i>
                                                                                            </button>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <button type="button"
                                                                                                class="btn showImage"
                                                                                                value="<?php echo $row['id']; ?>"
                                                                                                data-toggle="modal"
                                                                                                data-target="#imageModal1"
                                                                                                data-task-id='<?php echo htmlspecialchars($row['id']); ?>'>
                                                                                                <i class="fas fa-image" style="font-size: 20px;"></i>
                                                                                            </button>
                                                                                        </center>
                                                                                    </td>

                                                                                    <td>
                                                                                        <center>
                                                                                            <?php echo $row['h_reason']; ?>
                                                                                        </center>
                                                                                    </td>

                                                                                    <td>
                                                                                        <center>
                                                                                            <button type="button"
                                                                                                value="<?php echo $row['id']; ?>"
                                                                                                id="detail_id"
                                                                                                class="btn btn-success btnapprove">
                                                                                                <i class="fas fa-check"></i>
                                                                                            </button>
                                                                                            <button type="button"
                                                                                                value="<?php echo $row['id']; ?>"
                                                                                                class="btn btn-danger btnreject"
                                                                                                data-toggle="modal"
                                                                                                data-target="#rejectmodal">
                                                                                                <i class="fas fa-times"></i>
                                                                                            </button>
                                                                                        </center>
                                                                                    </td>
                                                                                <?php
                                                                                $id++;
                                                                            }
                                                                                ?>
                                                                                </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--------------approved tab-------------------->
                                            <div class="tab-pane p-20" id="approved" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="table-container">
                                                                    <table id="myTable2" class="table table-bordered table-striped fixed-size-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="pending status text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white; width: 40px;">
                                                                                    <b>S.No</b>
                                                                                </th>
                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white; width: 80px;">
                                                                                    <b>Date Registered</b>
                                                                                </th>
                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white; width: 70px;">
                                                                                    <b>Faculty Name</b>
                                                                                </th>
                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                                                    <b>Problem Description</b>
                                                                                </th>
                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                                                    <b>Image</b>
                                                                                </th>
                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                                                    <b>Status</b>
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $id = 1;
                                                                            while ($row = mysqli_fetch_assoc($result1)) {
                                                                            ?>
                                                                                <tr>
                                                                                    <td class="text-center">
                                                                                        <?php echo $id; ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <?php echo $row['date_of_reg']; ?>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <button type="button"
                                                                                                class="btn btn-link faculty" id="facultyinfo"
                                                                                                data-value="<?php echo $row['fac_id']; ?>"
                                                                                                data-toggle="modal" value="<?php echo $row['id']; ?>"
                                                                                                data-target="#facultymodal" style="text-decoration:none;"><?php echo $row['name']; ?></button>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <button type="button"
                                                                                                value='<?php echo $row['id']; ?>'
                                                                                                class="btn btndesc"
                                                                                                data-toggle="modal" id="seeproblem"
                                                                                                data-target="#probdesc">
                                                                                                <i class="fas fa-solid fa-eye" style="font-size: 20px;"></i>
                                                                                            </button>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <button type="button"
                                                                                                class="btn showImage"
                                                                                                value="<?php echo $row['id']; ?>"
                                                                                                data-toggle="modal"
                                                                                                data-target="#imageModal1"
                                                                                                data-task-id='<?php echo htmlspecialchars($row['id']); ?>'>
                                                                                                <i class="fas fa-image" style="font-size: 20px;"></i>
                                                                                            </button>
                                                                                        </center>
                                                                                    </td>

                                                                                    <td>
                                                                                        <center>
                                                                                            <?php
                                                                                            $statusMessages = [
                                                                                                2 => 'Forwarded to HOD',
                                                                                                4 => 'Forwaded to Estate Officer',
                                                                                                5 => 'Rejected By HOD',
                                                                                                6 => 'Sent to principal for approval',
                                                                                                8 => 'Accepted by Principal',
                                                                                                9 => 'Approved by Manager',
                                                                                                10 => 'Approved By Worker',
                                                                                                11 => 'Waiting for Approval',
                                                                                                13 => 'Sent to Faculty Infra Coordinator for completion',
                                                                                                14 => 'Feedback by faculty',
                                                                                                15 => 'Work is Reassigned',
                                                                                                16 => 'Work is Completed',
                                                                                                19 => 'Rejected By Principal',
                                                                                                20 => 'Rejected by Manager',
                                                                                                22 => 'Accepted by Estate Officer',
                                                                                                23 => 'Rejected By Estate Officer',
                                                                                            ];

                                                                                            $status = $row['status'];
                                                                                            $statusMessage = $statusMessages[$status] ?? 'Unknown status';
                                                                                            ?>
                                                                                            <button type="button" class="btn btn-secondary">
                                                                                                <?php echo $statusMessage; ?>
                                                                                            </button>
                                                                                        </center>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php
                                                                                $id++;
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
                                            <!------------------FeedBack Table----------------->
                                 <div class="tab-pane p-20" id="waitfeed" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="feedbackTable" class="table table-bordered table-striped">
                                                    <thead style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white; width: 40px;">
                                                        <tr>
                                                            <th class="text-center"><b>S.No</b></th>
                                                            <th class="text-center"><b>Problem_id</th>
                                                            <th class="text-center"><b>Venue</b></th>
                                                            <th class="text-center"><b>Problem description</b></th>
                                                            <th class="text-center"><b>Date Of submission</b></th>
                                                            <th class="text-center"><b>Deadline</b></th>
                                                            <th class="text-center"><b>After Image</b></th>
                                                            <th class="text-center"><b>Worker Details</b></th>
                                                            <th class="text-center"><b>Feedback</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $s = 1;
                                                        while ($row = mysqli_fetch_assoc($result11)) {
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
                                                                            data-toggle="modal"
                                                                            data-target="#extendModal"
                                                                            data-reason="<?php echo $row['extend_reason']; ?>">
                                                                            <?php echo $row['days_to_complete']; ?>
                                                                        </button>
                                                                    <?php } else { ?>
                                                                        <?php echo $row['days_to_complete']; ?>
                                                                    <?php } ?>
                                                                </td>
                                                                <td class="text-center">
                                                                <button type="button"
                                                                                                value="<?php echo htmlspecialchars($row['id']); ?>"
                                                                                                class="btn viewafterimgcomp"
                                                                                                data-toggle="modal"
                                                                                                data-target="#aftercomp"
                                                                                                data-imgs-id='<?php echo htmlspecialchars($row['id']); ?>'>
                                                                                                <i class="fas fa-image" style="font-size: 20px;"></i>
                                                                                            </button>
                                                                </td>


                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-light showWorkerDetails" value="<?php echo $row['id']; ?>">
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
                                                                 if($row['status'] == 14){
                                                                    ?>
                                                                    <button class="btn btn-success" >Submitted</button>

                                                                    <?php
                                                                 }
                                                                 else{
                                                                ?>
                                                                        <!-- Button to open the feedback modal -->
                                                                        <button type="button" class="btn btn-info feedbackBtn" data-problem-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#feedback_modal">Feedback</button>

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



                                            <!-----------completed tab----------->
                                            <div class="tab-pane p-20" id="completed" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="table-container">
                                                                    <table id="myTable3" class="table table-bordered table-striped fixed-size-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="pending status text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white; width: 40px;">
                                                                                    <b>S.No</b>
                                                                                </th>
                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white; width: 80px;">
                                                                                    <b>Date Registered</b>
                                                                                </th>
                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white; width: 70px;">
                                                                                    <b>Faculty Name</b>
                                                                                </th>
                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                                                    <b>Problem Description</b>
                                                                                </th>
                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                                                    <b>Before Image</b>
                                                                                </th>
                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                                                    <b>After Image</b>
                                                                                </th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $id = 1;
                                                                            while ($row = mysqli_fetch_assoc($result2)) {
                                                                            ?>
                                                                                <tr>
                                                                                    <td class="text-center">
                                                                                        <?php echo $id; ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <?php echo $row['date_of_reg']; ?>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <button type="button"
                                                                                                class="btn btn-link faculty" id="facultyinfo"
                                                                                                data-value="<?php echo $row['fac_id']; ?>"
                                                                                                data-toggle="modal" value="<?php echo $row['id']; ?>"
                                                                                                data-target="#facultymodal" style="text-decoration:none;"><?php echo $row['name']; ?></button>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <button type="button"
                                                                                                value="<?php echo $row['id']; ?>"
                                                                                                class="btn btndesc"
                                                                                                data-toggle="modal" id="seeproblem"
                                                                                                data-target="#probdesc">
                                                                                                <i class="fas fa-solid fa-eye" style="font-size: 20px;"></i>
                                                                                            </button>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <button type="button"
                                                                                                class="btn showImage"
                                                                                                value="<?php echo $row['id']; ?>"
                                                                                                data-toggle="modal"
                                                                                                data-target="#imageModal1"
                                                                                                data-task-id='<?php echo htmlspecialchars($row['id']); ?>'>
                                                                                                <i class="fas fa-image" style="font-size: 20px;"></i>
                                                                                            </button>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <button type="button"
                                                                                                value="<?php echo htmlspecialchars($row['id']); ?>"
                                                                                                class="btn viewafterimgcomp"
                                                                                                data-toggle="modal"
                                                                                                data-target="#aftercomp"
                                                                                                data-imgs-id='<?php echo htmlspecialchars($row['id']); ?>'>
                                                                                                <i class="fas fa-image" style="font-size: 20px;"></i>
                                                                                            </button>
                                                                                        </center>
                                                                                    </td>

                                                                                </tr>
                                                                            <?php
                                                                                $id++;
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

                                            <!----------rejected tab------->
                                            <div class="tab-pane p-20" id="rejected" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="table-container">
                                                                    <table id="myTable4" class="table table-bordered table-striped fixed-size-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="pending status text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white; width: 40px;">
                                                                                    <b>S.No</b>
                                                                                </th>
                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white; width: 80px;">
                                                                                    <b>Date Registered</b>
                                                                                </th>
                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white; width: 70px;">
                                                                                    <b>Faculty Name</b>
                                                                                </th>
                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                                                    <b>Problem Description</b>
                                                                                </th>
                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                                                    <b>Image</b>
                                                                                </th>

                                                                                <th class="text-center"
                                                                                    style="background-color: #7460ee; background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                                                    <b>Reason</b>
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $id = 1;
                                                                            while ($row = mysqli_fetch_assoc($result3)) {
                                                                            ?>
                                                                                <tr>
                                                                                    <td class="text-center">
                                                                                        <?php echo $id; ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <?php echo $row['date_of_reg']; ?>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <button type="button"
                                                                                                class="btn btn-link faculty" id="facultyinfo"
                                                                                                data-value="<?php echo $row['fac_id']; ?>"
                                                                                                data-toggle="modal" value="<?php echo $row['id']; ?>"
                                                                                                data-target="#facultymodal" style="text-decoration:none;"><?php echo $row['name']; ?></button>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <button type="button"
                                                                                                value="<?php echo $row['id']; ?>"
                                                                                                class="btn btndesc"
                                                                                                data-toggle="modal" id="seeproblem"
                                                                                                data-target="#probdesc">
                                                                                                <i class="fas fa-solid fa-eye" style="font-size: 20px;"></i>
                                                                                            </button>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <button type="button"
                                                                                                value="<?php echo $row['id']; ?>"
                                                                                                class="btn showImage"
                                                                                                data-toggle="modal"
                                                                                                data-target="#imageModal1"
                                                                                                data-task-id='<?php echo htmlspecialchars($row['id']); ?>'>
                                                                                                <i class="fas fa-image" style="font-size: 20px;"></i>
                                                                                            </button>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <button type="button" value="<?php echo $row['id']; ?>" class="btn btn-danger btnrejfeed" data-toggle="modal"
                                                                                                data-target="#problemrejected" id="rejectedfeedback">
                                                                                                <i class="fas fa-solid fa-comment" style="font-size: 20px; width:40px;"></i>
                                                                                            </button>
                                                                                        </center>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php
                                                                                $id++;
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer text-center">
            <b>
                2024 © M.Kumarasamy College of Engineering All Rights Reserved.<br>
                Developed and Maintained by Technology Innovation Hub.
            </b>
        </footer>
    </div>

    <!------------Rejected Feedback modal----->
    <div class="modal fade" id="rejectmodal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"
                    style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Reason for rejection</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="rejectdetails">
                    <div class="modal-body" style="font-size:larger;">
                        <textarea class="form-control"
                            placeholder="Enter Reason"
                            name="rejfeed"
                            style="width:460px;height: 180px; resize:none" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

     <!-- Worker Details Modal -->
     <div class="modal fade" id="workerModal" tabindex="-1" aria-labelledby="workerModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);background-color:#7460ee;">
                                                    <h5 class="modal-title" id="exampleModalLabel">Worker Phone</h5>
                                                    <button class="spbutton" type="button" class="btn-close" data-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                            <div class="modal-body">
                                                <div class="box" style="background-color: #f7f7f7; border: 1px solid #ccc; padding: 15px; margin-bottom: 10px; border-radius: 5px;">
                                                    <p><strong>Contact:</strong> <span id="workerContact"></span></p>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <a href="#" id="callWorkerBtn" class="btn btn-success">Call Worker</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

     <!-- Feedback Modal -->
     <div class="modal fade" id="feedback_modal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);background-color:#7460ee;">
                                                    <h5 class="modal-title" id="exampleModalLabel">Feedback Form</h5>
                                                    <button class="spbutton" type="button" class="btn-close" data-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                            <div class="modal-body">
                                                <form id="add_feedback">
                                                    <input type="hidden" name="id" id="feedback_id"> <!-- Hidden input for id -->
                                                    <div class="mb-3">
                                                        <label for="satisfaction" class="form-label">Satisfaction</label>
                                                        <select name="satisfaction" id="satisfaction" class="form-control" required>
                                                            <option value="" disabled selected>Select an option</option>
                                                            <option value="Satisfied">Satisfied</option>
                                                            <option value="Not Satisfied">Reassign</option>
                                                        </select>
                                                    </div>
                                                    <div class="stars" id="star-rating">
                                                        <h5>Give Rating:</h5>
                                                        <span data-value="1">&#9733;</span>
                                                        <span data-value="2">&#9733;</span>
                                                        <span data-value="3">&#9733;</span>
                                                        <span data-value="4">&#9733;</span>
                                                        <span data-value="5">&#9733;</span>
                                                    </div>
                                                    <p id="rating-value">Rating: <span id="ratevalue">0</span></p>

                                                    <div class="mb-3">
                                                        <label for="feedback" class="form-label">Feedback</label>
                                                        <textarea name="feedback" id="feedback" class="form-control" placeholder="Enter Feedback" style="width: 100%; height: 150px;"></textarea>
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

    <!--faculty info modal-->
    <div class="modal fade" id="facultymodal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"
                    style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                    <h5 class="modal-title" id="exampleModalLabel">Faculty Information</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 15px; font-size: 1.1em; color: #333; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                    <ol class="list-group list-group-numbered" style="margin-bottom: 0;">
                        <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Faculty Name</div>
                                <b><span id="faculty_name" style="color: #555;"></span></b>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Faculty mobile</div>
                                <b><span id="faculty_mobile" style="color: #555;"></span></b>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Faculty Email</div>
                                <b><span id="faculty_email" style="color: #555;"></span></b>
                            </div>
                        </li>

                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!---view problem description modal-->
    <div class="modal fade" id="probdesc" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Problem Description</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addnewdetails">
                    <div class="modal-body" style="padding: 15px; font-size: 1.1em; color: #333; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                        <ol class="list-group list-group-numbered" style="margin-bottom: 0;">
                            <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Problem ID</div>
                                    <b><span id="id" style="color: #555;"></span></b>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Type of Problem</div>
                                    <b><span id="type_of_problem" style="color: #555;"></span></b>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Block</div>
                                    <b><span id="block_venue" style="color: #555;"></span></b>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Venue Name</div>
                                    <b><span id="venue_name" style="color: #555;"></span></b>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Problem Description</div>
                                    <b><span id="pd" style="color: #555;padding-top:5px;"></span></b>
                                </div>
                            </li>
                        </ol>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- After Image Modal -->
    <div class="modal fade" id="afterImageModal" tabindex="-1" role="dialog"
        aria-labelledby="afterImageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="afterImageModalLabel">After Picture</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage2" src="" alt="After" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="bmodalImage" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Before Image</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="bimg" src="" alt="Image Preview" style="max-width: 100%;" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane p-20" id="home" role="tabpanel">
        <div class="modal fade" id="raisemodal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Raise Complaint</h5>
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div>
                        <form id="addnewuser" enctype="multipart/form-data" onsubmit="handleSubmit(event)">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="block" class="form-label">Block <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="block_venue" placeholder="Eg:RK-206" required>
                                </div>
                                <div class="mb-3">
                                    <label for="venue" class="form-label">Venue <span style="color: red;">*</span></label>
                                    <select id="dropdown" class="form-control" name="venue_name" onchange="checkIfOthers()"
                                        style="width: 100%; height:36px;">
                                        <option>Select</option>
                                        <option value="class">Class Room</option>
                                        <option value="department">Department</option>
                                        <option value="lab">Lab</option>
                                        <option value="staff_room">Staff Room</option>
                                        <option id="oth" value="Other">Others</option>
                                    </select>
                                </div>

                                <div id="othersInput" style="display: none;">
                                    <label class="form-label" for="otherValue">Please specify: <span style="color: red;">*</span></label>
                                    <input class="form-control" type="text" id="otherValue" name="otherValue"> <br>
                                </div>

                                <div class="mb-3">
                                    <label for="type_of_problem" class="form-label">Type of Problem <span style="color: red;">*</span></label>
                                    <select class="form-control" name="type_of_problem" style="width: 100%; height:36px;">
                                        <option>Select</option>
                                        <option value="elecrtical">ELECTRICAL</option>
                                        <option value="civil">CIVIL</option>
                                        <option value="itkm">ITKM </option>
                                        <option value="transport">TRANSPORT</option>
                                        <option value="house">HOUSE KEEPING </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Problem Description <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="problem_description" placeholder="Enter Description" required>
                                </div>
                                <div class="mb-3">
                                    <label for="images" class="form-label">Image <span style="color: red;">*</span> </label>
                                    <input type="file" class="form-control" name="images" id="images" onchange="validateSize(this)" required>
                                </div>
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" name="date_of_reg" id="date_of_reg" required>
                                </div>
                            </div>
                            <input type="hidden" name="status" value="2">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!------------Rejected Reason modal-------------->
        <div class="modal fade" id="problemrejected" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                        <h5 class="modal-title" id="exampleModalLabel">Reason for Rejection</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="addnewdetails">
                        <div class="modal-body" style="padding: 15px; font-size: 1.1em; color: #333; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                            <ol class="list-group list-group-numbered" style="margin-bottom: 0;">
                                <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Rejected By</div>
                                        <b><span id="pdrej2" style="color: #555;"></span></b>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Reason</div>
                                        <b><span id="rejby" style="color: #555;"></span></b>
                                    </div>
                                </li>
                            </ol>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Close</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- All Jquery -->
        <!-- ============================================================== -->
        <script src="assets/libs/jquery/dist/jquery.min.js"></script>
        <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
        <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
        <script src="assets/extra-libs/sparkline/sparkline.js"></script>
        <script src="dist/js/waves.js"></script>
        <script src="dist/js/sidebarmenu.js"></script>
        <script src="dist/js/custom.min.js"></script>
        <script src="assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>
        <script src="assets/extra-libs/multicheck/jquery.multicheck.js"></script>
        <script src="assets/extra-libs/DataTables/datatables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/alertify.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/alertifyjs/build/alertify.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


        <!-- Set Today date in Raise Complaint-->
        <script>
            var today = new Date().toISOString().split('T')[0];
            var dateInput = document.getElementById('date_of_reg');
            dateInput.setAttribute('min', today);
            dateInput.setAttribute('max', today);
            dateInput.value = today;
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
            //Tool Tip
            $(function() {
                // Initialize the tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // You can also set options manually if needed
                $('.btnreject').tooltip({
                    placement: 'top',
                    title: 'Reject'
                });
            });

            $(function() {
                // Initialize the tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // You can also set options manually if needed
                $('.btnrejfeed').tooltip({
                    placement: 'top',
                    title: 'Rejected Reason'
                });
            });

            $(function() {
                // Initialize the tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // You can also set options manually if needed
                $('.btndesc').tooltip({
                    placement: 'top',
                    title: 'Problem Description'
                });
            });

            $(function() {
                // Initialize the tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // You can also set options manually if needed
                $('.viewafterimgcomp').tooltip({
                    placement: 'top',
                    title: 'After Image'
                });
            });

            $(function() {
                // Initialize the tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // You can also set options manually if needed
                $('.btnraisecomp').tooltip({
                    placement: 'top',
                    title: 'Raise Complaint'
                });
            });

            $(function() {
                // Initialize the tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // You can also set options manually if needed
                $('.btnapprove').tooltip({
                    placement: 'top',
                    title: 'Accept'
                });
            });

            $(function() {
                // Initialize the tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // You can also set options manually if needed
                $('.showImage').tooltip({
                    placement: 'top',
                    title: 'Before Image'
                });
            });

            alertify.set('notifier', 'position', 'top-right');
            $(document).ready(function() {
                $('#myTable1').DataTable();
                $('#myTable2').DataTable();
                $('#myTable3').DataTable();
                $('#myTable4').DataTable();
                $('#feedbackTable').DataTable();

            });

            $(document).on("click", ".btnreject", function (e) {
    e.preventDefault();
    var u_id = $(this).val();
    console.log("User ID stored:", u_id);
    $(document).data("user_id_reject", u_id);
});

            //Reject Button with Feedback
            $('#rejectdetails').on('submit', function(e) {
                e.preventDefault();

                if (confirm('Are you sure you want to reject this complaint?')) {
                    var formdata1 = new FormData(this);
                    var reject_id = $(document).data("user_id_reject");

                    formdata1.append("reject_id", reject_id);
                    $.ajax({
                        type: "POST",
                        url: 'cms_backend.php?action=rejectbtn',
                        data: formdata1,
                        processData: false,
                        contentType: false,

                        success: function(response) {
                            var res = jQuery.parseJSON(response);
                            if (res.status == 200) {
                                $('#rejectmodal').modal('hide');
                                $('#rejectdetails')[0].reset();
                                $('#myTable1').load(location.href + " #myTable1");
                                $('#myTable4').load(location.href + " #myTable4");
                                $('#myTable1').DataTable().destroy();
                                $('#myTable4').DataTable().destroy();
                                $("#myTable1").load(location.href + " #myTable1 > *", function() {
                                    $('#myTable1').DataTable();
                                });
                                $("#myTable4").load(location.href + " #myTable4 > *", function() {
                                    $('#myTable4').DataTable();
                                });
                                $('#navref1').load(location.href + " #navref1");
                                $('#navref4').load(location.href + " #navref4");

                            } else if (res.status == 500) {
                                alertify.error('Complaint Rejected!');
                                $('#rejectmodal').modal('hide');
                                $('#rejectdetails')[0].reset();
                                console.error("Error:", res.message);
                                alert("Something Went wrong.! try again")
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX error:", error);
                            alert("An error occurred: " + error);
                        }
                    });

                    sendRejectionMail(reject_id);
                }
            });

            //sending mail for complaint reject

            function sendRejectionMail(id) {
    var user_type = "Head of the Department";
    $.ajax({
        type: "POST",
        url: "cms_mail.php",
        data: {
            'reject_mail': true,
            'id': id,
            'user_type': user_type,
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

            //approve button
            $(document).on('click', '.btnapprove', function(e) {
                e.preventDefault();

                var approveid = $(this).val();

                alertify.confirm('Confirmation', 'Are you sure you want to approve this complaint?',
                    function() {
                        $.ajax({
                            type: "POST",
                            url: 'cms_backend.php?action=approvebtn',
                            data: {
                                'approve': approveid
                            },
                            success: function(response) {
                                var res = jQuery.parseJSON(response);
                                if (res.status == 500) {
                                    alertify.error(res.message);
                                } else {
                                    alertify.success('Complaint Approved successfully!');
                                    $('#myTable1').DataTable().destroy();
                                    $('#myTable2').DataTable().destroy();
                                    $('#myTable3').DataTable().destroy();
                                    $("#myTable1").load(location.href + " #myTable1 > *", function() {
                                        $('#myTable1').DataTable();
                                    });
                                    $("#myTable2").load(location.href + " #myTable2 > *", function() {
                                        $('#myTable2').DataTable();
                                    });
                                    $("#myTable3").load(location.href + " #myTable3 > *", function() {
                                        $('#myTable3').DataTable();
                                    });
                                    $('#navref1').load(location.href + " #navref1");
                                    $('#navref2').load(location.href + " #navref2");
                                    $('#navref3').load(location.href + " #navref3");
                                    $('#navref4').load(location.href + " #navref4");
                                }
                            }
                        });
                    },
                    function() {
                        alertify.error('Approval canceled');
                    });
            });

            // Add Faculty complaints to database
            $(document).on('submit', '#addnewuser', function(e) {
                e.preventDefault(); // Prevent form from submitting normally
                var formData = new FormData(this);
                formData.append("hod", true);
                $.ajax({
                    type: "POST",
                    url: 'cms_backend.php?action=addcomplaint',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = typeof response === 'string' ? JSON.parse(response) : response;
                        if (res.status === 200) {
                            swal("Complaint Submitted!", "", "success");
                            $('#raisemodal').modal('hide');
                            $('#addnewuser')[0].reset(); // Reset the form
                            $('#navref1').load(location.href + " #navref1");
                            $('#navref2').load(location.href + " #navref2");
                            $('#navref3').load(location.href + " #navref3");
                            $('#dashref').load(location.href + " #dashref");

                            $('#user').DataTable().destroy();
                            $("#user").load(location.href + " #  > *", function() {
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
            // problem description
            $(document).on('click', '#seeproblem', function(e) {
                e.preventDefault();
                var user_id = $(this).val();
                console.log(user_id)
                $.ajax({
                    type: "POST",
                    url: "cms_backend.php?action=seeproblem",
                    data: {
                        'seedetails': true,
                        'user_id': user_id
                    },
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        console.log(res)
                        if (res.status == 500) {
                            alert(res.message);
                        } else {
                            $("#id").text(res.data.id);
                            $("#type_of_problem").text(res.data.type_of_problem);
                            $("#block_venue").text(res.data.block_venue);
                            $("#venue_name").text(res.data.venue_name);
                            $('#pd').text(res.data.problem_description);
                            $('#probdesc').modal('show');
                        }
                    }
                });
            });

            // faculty info
            $(document).on('click', '#facultyinfo', function(e) {
                e.preventDefault();
                var user_id = $(this).val();
                var faculty_id = $(this).data("value");

                console.log(user_id);
                console.log(faculty_id);
                $.ajax({
                    type: "POST",
                    url: 'cms_backend.php?action=facinfohod',
                    data: {
                        'facultydetails': true,
                        'user_id': user_id,
                        'fac_id': faculty_id
                    },
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        console.log(res)
                        if (res.status == 500) {
                            alert(res.message);
                        } else {
                            $("#id").val(res.data.id);
                            $("#faculty_name").text(res.data.fname);
                            $("#faculty_email").text(res.data.email);
                            $("#faculty_mobile").text(res.data.mobile);


                            $('#facultymodal').modal('show');
                        }
                    }
                });
            });

            //Image Modal Ajax
            $(document).on('click', '.showImage', function() {
                var task_id = $(this).val();
                console.log(task_id);

                $.ajax({
                    type: "POST",
                    url: 'cms_backend.php?action=bimgforhod',
                    data: {
                        'get_image': true,
                        'task_id': task_id
                    },
                    success: function(response) {
                        console.log(response);
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            $('#bimg').attr('src', "uploads/" + res.data);
                            $('#bmodalImage').modal('show');
                        } else {
                            $('#modalImage').hide();
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred while retrieving the image.');
                    }
                });
            });

            //After Image Modal
            $(document).on('click', '.viewafterimgcomp', function() {
                var task_id = $(this).val();
                console.log(task_id);

                // Fetch the image from the server
                $.ajax({
                    type: "POST",
                    url: 'cms_backend.php?action=get_aimage',
                    data: {
                        'after_image': true,
                        'problem2_id': task_id
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response); // Log the parsed JSON response
                        if (response.status == 200) { // Use 'response' instead of 'res'
                            // Dynamically set the image source
                            $("#modalImage2").attr("src", response.data.after_photo);
                            // Show the modal
                            $("#afterImageModal").modal("show");
                        } else {
                            // Handle case where no image is found
                            alert(response.message ||
                                "An error occurred while retrieving the image.");
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

            //Rejected Tab Feedback
            $(document).on('click', '#rejectedfeedback', function(e) {
                e.preventDefault();
                var user_idrej = $(this).val();
                console.log(user_idrej)
                $.ajax({
                    type: "POST",
                    url: 'cms_backend.php?action=rejfeedback',
                    data: {
                        'seefeedback': true,
                        'user_idrej': user_idrej

                    },
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        console.log(res);
                        if (res.status == 500) {
                            alert(res.message);
                        } else {
                            let rejectionReason = "";
                            switch (res.data2.status) {
                                case '19':
                                    rejectionReason = "Rejected by Manager";
                                    break;
                                case '20':
                                    rejectionReason = "Rejected by Principal";
                                    break;
                                case '23':
                                    rejectionReason = "Rejected by Estate Officer";
                                    break;
                                default:
                                    rejectionReason = "Unknown rejection reason";
                            }
                            $('#pdrej2').text(rejectionReason);
                            $('#rejby').text(res.data2.feedback);
                            $('#problemrejected').modal('show');
                        }
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


                        $('#navref1').load(location.href + " #navref1");
                        $('#navref3').load(location.href + " #navref3");
                        $('#navref4').load(location.href + " #navref4");
                        $('#navref33').load(location.href + " #navref33");

                        $('#dashref').load(location.href + " #dashref");

                        $('#myTable1').DataTable().destroy();
                        $("#myTable1").load(location.href + " #myTable1 > *", function() {
                            $('#myTable1').DataTable();
                        });

                        $('#myTable2').DataTable().destroy();
                        $("#myTable2").load(location.href + " #myTable2 > *", function() {
                            $('#myTable2').DataTable();
                        });

                        $('#feedbackTable').DataTable().destroy();
                        $("#feedbackTable").load(location.href + " #feedbackTable > *", function() {
                            $('#feedbackTable').DataTable();
                        });

                        $('#myTable3').DataTable().destroy();
                        $("#myTable3").load(location.href + " #myTable3 > *", function() {
                            $('#myTable3').DataTable();
                        });
                        $('#myTable4').DataTable().destroy();
                        $("#myTable4").load(location.href + " #myTable4 > *", function() {
                            $('#myTable4').DataTable();
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