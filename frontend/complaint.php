<?php
require 'config.php';
include('session.php');
$faculty_id = $s;
$role  = $frole;
if ($role != "principal") {
    header("Location:index.php");
}
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
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" integrity="sha512-IXuoq1aFd2wXs4NqGskwX2Vb+I8UJ+tGJEu/Dc0zwLNKeQ7CW3Sr6v0yU3z5OQWe3eScVIkER4J9L7byrgR/fA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS (Optional but recommended) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>MIC</title>
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <!--For data table-->
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
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
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a
                                class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                    </ul>
                    <ul class="navbar-nav float-right">
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

        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="p-t-30">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="principal"
                                aria-expanded="false"><img src="images/icon/dash.png" class="custom-svg-icon"
                                    alt="Dashboard Icon"><span class="hide-menu">&nbsp;Dashboard</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link active" href="complaint"
                                aria-expanded="false"><img src="images/icon/feedback1.png" class="custom-svg-icon"
                                    alt="Dashboard Icon"><span class="hide-menu">&nbsp;Complaints</span></a></li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Complaint Status</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="principal.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Complaint</li>
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


                <!-- Tabs -->
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#table1"
                                            role="tab"><span class="hidden-sm-up"></span> <span
                                                class="hidden-xs-down"><i class="mdi mdi-book-open"></i>&nbsp Requirements</span></a>
                                    </li>
                                    <li class="nav-item"> <a class="nav-link " data-toggle="tab" href="#completed"
                                            role="tab"><span class="hidden-sm-up"></span> <span
                                                class="hidden-xs-down"><i class="mdi mdi-book-open"></i>&nbsp Completed Work</span></a>
                                    </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#inprogress"
                                            role="tab"><span class="hidden-sm-up"></span> <span
                                                class="hidden-xs-down"><i class="mdi mdi-book-open"></i>&nbsp Work
                                                Assigned</span></a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#complaints"
                                            role="tab"><span class="hidden-sm-up"></span> <span
                                                class="hidden-xs-down"><i class="mdi mdi-file-document"></i>&nbsp My Complaints</span></a> </li>
                                    <li class="nav-item">

                                        <a class="nav-link" data-toggle="tab" href="#waitfeed" role="tab" aria-selected="false">
                                            <span class="hidden-sm-up"></span>
                                            <div id="navref33">
                                                <span class="hidden-xs-down">
                                                    <i class="bi bi-people-fill"></i>
                                                    <i class="fas fa-clock"></i>
                                                    <b>&nbsp Feedback</b>
                                                </span>
                                            </div>
                                        </a>

                                    </li>


                                </ul>
                                <!-- Tab panes -->
                                <!-- Requirement's Table -->
                                <div class="tab-content tabcontent-border">


                                    <div class="tab-pane active p-20" id="table1" role="tabpanel">
                                        <div class="p-20">
                                            <div class="table-responsive">
                                                <h5 class="card-title">Requirements
                                                    <button type="button" class="btn btn-info float-right fac" data-toggle="modal" data-target="#cmodal">Raise Compliant</button><br>
                                                </h5>
                                                <br>
                                                <table id="addnewtask" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>

                                                            <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                                    <h5>S.No</h5>
                                                                </b></th>
                                                            <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                                    <h5>Block \ Venue</h5>
                                                                </b></th>
                                                            <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                                    <h5>Complaint</h5>
                                                                </b></th>
                                                            <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                                    <h5>Image</h5>
                                                                </b></th>
                                                            <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                                    <h5>Date raised</h5>
                                                                </b></th>

                                                            <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                                    <h5>Requirements</h5>
                                                                </b></th>
                                                            <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                                    <h5>Action</h5>
                                                                </b></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $s = 1;
                                                        while ($row = mysqli_fetch_array($result11)) {
                                                        ?>
                                                            <tr>
                                                                <td class="text-center" scope="row"><?php echo $s ?></td>

                                                                <td class="text-center"><?php echo $row['block_venue'] ?> \ <?php echo $row['venue_name'] ?></td>

                                                                <td class="text-center">
                                                                    <button type="button" value="<?php echo $row['id']; ?>"
                                                                        class="btn viewcomplaint"
                                                                        data-value="<?php echo $row['fac_id']; ?>">
                                                                        <i class="fas fa-eye" style="font-size: 25px;"></i>
                                                                    </button>
                                                                </td>


                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-light btn-sm showImage"
                                                                        value="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#imageModal">
                                                                        <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                    </button>
                                                                </td>

                                                                <td class="text-center"><?php echo $row['date_of_reg'] ?></td>

                                                                <td class="text-center"><?php echo $row['p_reason'] ?></td>
                                                                <td class="text-center">
                                                                    <button type="button" value="<?php echo $row['id'] ?>" class="btn btn-success userapprove"><i class="fas fa-check"></i></button>

                                                                    <button type="button" value="<?php echo $row['id']; ?>" class="btn btn-danger userreject" data-toggle="modal" data-target="#rejectModal"><i class="fas fa-times"></i></button>

                                                                </td>
                                                            </tr>
                                                        <?php
                                                        }
                                                        $s++
                                                        ?>

                                                    </tbody>

                                                </table>
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
                                    <!-- Completed Table -->
                                    <div class="tab-pane p-20" id="completed" role="tabpanel">
                                        <div class="p-20">
                                            <div class="table-responsive">
                                                <h5 class="card-title">Work's Completed</h5>
                                                <table id="completed_table" class="table table-striped table-bordered">
                                                    <thead style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                        <tr>

                                                            <th class="text-center"><b>
                                                                    <h5>S.No</h5>
                                                                </b></th>
                                                            <th class="text-center"><b>
                                                                    <h5>Block/Venue</h5>
                                                                </b></th>
                                                            <th class="col-md-2 text-center"><b>
                                                                    <h5>Complaint</h5>
                                                                </b></th>
                                                            <th class="text-center"><b>
                                                                    <h5>Deadline</h5>
                                                                </b></th>
                                                            <th class="col-md-2 text-center"><b>
                                                                    <h5>Date of Completion</h5>
                                                                </b></th>
                                                            <th class="col-md-2 text-center"><b>
                                                                    <h5>Images</h5>
                                                                </b></th>
                                                            <th class=" col-md-2 text-center"><b>
                                                                    <h5>Faculty Feedback</h5>
                                                                </b></th>
                                                            <th class=" col-md-2 text-center"><b>
                                                                    <h5>Status</h5>
                                                                </b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $s = 1;
                                                        while ($row6 = mysqli_fetch_assoc($result1)) {
                                                        ?>
                                                            <tr>
                                                                <td class="text-center"><?php echo $s ?></td>
                                                                <td class="text-center"><?php echo $row6['block_venue'] ?>/<?php echo $row6['venue_name'] ?></td>
                                                                <td class="text-center">
                                                                    <button type="button" value="<?php echo $row6['id']; ?>"
                                                                        class="btn viewcomplaint"
                                                                        data-value="<?php echo $row6['fac_id']; ?>">
                                                                        <i class="fas fa-eye" style="font-size: 25px;"></i>
                                                                    </button>
                                                                </td>
                                                                <td class="text-center"><?php echo $row6['days_to_complete'] ?></td>
                                                                <td class="text-center"><?php echo $row6['date_of_completion'] ?></td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-light btn-sm showImage"
                                                                        value="<?php echo $row6['id']; ?>" data-toggle="modal" data-target="#imageModal">
                                                                        <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                    </button>
                                                                    <button value="<?php echo $row6['id']; ?>" type="button"
                                                                        class="btn btn-light btn-sm imgafter"
                                                                        data-toggle="modal">
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


                                    <!-- work assigned tabs... -->
                                    <div class="tab-pane" id="inprogress" role="tabpanel">
                                        <div class="p-20">
                                            <div class="card">
                                                <div class="card-body" style="padding: 10px;">
                                                    <div class="filter-section" style="float:right">

                                                    </div>

                                                    <div class="table-responsive">
                                                        <h5 class="card-title">Work's Assigned</h5>
                                                        <!-- Table for In Progress tasks -->
                                                        <table id="dataTable1" class="table table-striped table-bordered">
                                                            <thead style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                                <tr>
                                                                    <th class="text-center"><b>
                                                                            <h5>S.No</h5>
                                                                        </b></th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Block/Venue</h5>
                                                                        </b></th>
                                                                    <th class="col-md-2 text-center"><b>
                                                                            <h5>Complaint</h5>
                                                                        </b></th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Assigned Date</h5>
                                                                        </b></th>
                                                                    <th class="col-md-2 text-center"><b>
                                                                            <h5>Deadline</h5>
                                                                        </b></th>
                                                                    <th class="col-md-2 text-center"><b>
                                                                            <h5>Images</h5>
                                                                        </b></th>
                                                                    <th class=" col-md-2 text-center"><b>
                                                                            <h5>Comments</h5>
                                                                        </b></th>
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
                                                                        <td class="text-center"><?php echo $row['block_venue'] ?> / <?php echo $row['venue_name'] ?></td>
                                                                        <td class="text-center">
                                                                            <button type="button" value="<?php echo $row['id']; ?>"
                                                                                class="btn viewcomplaint"
                                                                                data-value="<?php echo $row['fac_id']; ?>">
                                                                                <i class="fas fa-eye" style="font-size: 25px;"></i>
                                                                            </button>
                                                                        </td>
                                                                        <td class="text-center"><?php echo $row['manager_approve'] ?></td>
                                                                        <td class="text-center"><?php echo $row['days_to_complete'] ?></td>
                                                                        <td class="text-center">
                                                                            <button type="button" class="btn btn-light btn-sm showImage"
                                                                                value="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#imageModal">
                                                                                <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                            </button>
                                                                            <button value="<?php echo $row['id']; ?>" type="button"
                                                                                class="btn btn-light btn-sm imgafter"
                                                                                data-toggle="modal">
                                                                                <i class="fas fa-images" style="font-size: 25px;"></i>
                                                                            </button>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <button type="button" value="<?php echo $row['task_id']; ?>"
                                                                                class="btn <?php

                                                                                            if (!empty($row['comment_query']) && !empty($row['comment_reply'])) {
                                                                                                echo 'btn-success'; // Green if both query and reply exist
                                                                                            } elseif (!empty($row['comment_query']) && empty($row['comment_reply'])) {
                                                                                                echo 'btn-warning'; // Yellow if only query exists
                                                                                            }  // Yellow if only query exists
                                                                                            else {
                                                                                                echo 'btn-info'; // Default blue if neither query nor reply exists
                                                                                            }
                                                                                            ?> details " data-toggle="modal" data-target="#comment">Comment</button>
                                                                        </td>
                                                                        <!-- Comment Modal -->
                                                                        <div class="modal fade" id="comment" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="rejectModalLabel">Comment Forum</h5>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <form id="comment_det">
                                                                                        <div class="modal-body">
                                                                                            <input type="hidden" name="task_id" id="task_id">
                                                                                            <!-- Query Field -->
                                                                                            <label class="form-label">Query*</label>
                                                                                            <input type="text" class="form-control" id="comment_query" name="comment_query" placeholder="Enter your query here">
                                                                                            <input type="text" class="form-control" id="query_date" name="query_date" placeholder="Date of Query Submission">
                                                                                            <!-- Reply Field -->
                                                                                            <label class="form-label">Reply*</label>
                                                                                            <input type="text" class="form-control" id="comment_reply" name="comment_reply" placeholder="Reply will be displayed here" readonly>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                            <button type="submit" class="btn btn-primary">Submit</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
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

                                    <!------------------FeedBack Table----------------->
                                    <div class="tab-pane p-20" id="waitfeed" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table id="feedbackTable" class="table table-bordered table-striped">
                                                        <thead style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;">
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
                                                                        <button value="<?php echo $row6['id']; ?>" type="button"
                                                                            class="btn btn-light btn-sm imgafter"
                                                                            data-toggle="modal">
                                                                            <i class="fas fa-images" style="font-size: 25px;"></i>
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
                                                                        if ($row['status'] == 14) {
                                                                        ?>
                                                                            <button class="btn btn-success">Submitted</button>

                                                                        <?php
                                                                        } else {
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

                                    <!-- My Complaints Table -->
                                    <div class="tab-pane p-20" id="complaints" role="tabpanel">
                                        <div class="p-20">
                                            <div class="table-responsive">
                                                <h5 class="card-title">My Complaints</h5>
                                                <table id="complaints_table" class="table table-striped table-bordered">
                                                    <thead style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                        <tr>

                                                            <th class="text-center"><b>
                                                                    <h5>S.No</h5>
                                                                </b></th>
                                                            <th class="text-center"><b>
                                                                    <h5>Complaint ID</h5>
                                                                </b></th>
                                                            <th class="text-center"><b>
                                                                    <h5>Block/Venue</h5>
                                                                </b></th>
                                                            <th class="col-md-2 text-center"><b>
                                                                    <h5>Complaint Details</h5>
                                                                </b></th>
                                                            <th class="col-md-2 text-center"><b>
                                                                    <h5>Date of Completion</h5>
                                                                </b></th>
                                                            <th class="col-md-2 text-center"><b>
                                                                    <h5>Images</h5>
                                                                </b></th>
                                                            <th class="col-md-2 text-center"><b>
                                                                    <h5>Status</h5>
                                                                </b></th>

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
                                                                <td class="text-center"><?php echo $row6['block_venue'] ?>/<?php echo $row6['venue_name'] ?></td>
                                                                <td class="text-center">
                                                                    <button type="button" value="<?php echo $row6['id']; ?>"
                                                                        class="btn viewcomplaint"
                                                                        data-value="<?php echo $row6['fac_id']; ?>">
                                                                        <i class="fas fa-eye" style="font-size: 25px;"></i>
                                                                    </button>
                                                                </td>
                                                                <td class="text-center"><?php echo $row6['date_of_completion'] ?></td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-light btn-sm showImage"
                                                                        value="<?php echo $row6['id']; ?>" data-toggle="modal" data-target="#imageModal">
                                                                        <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                    </button>
                                                                    <button value="<?php echo $row6['id']; ?>" type="button"
                                                                        class="btn btn-light btn-sm imgafter"
                                                                        data-toggle="modal">
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

                                <!-- ============================================================== -->
                                <!-- End Container fluid  -->
                                <!-- ============================================================== -->
                                <!-- ============================================================== -->
                                <!-- footer -->
                                <!-- ============================================================== -->

                                <!-- ============================================================== -->
                                <!-- End footer -->
                                <!-- ============================================================== -->
                            </div>
                            <!-- ============================================================== -->
                            <!-- End Page wrapper  -->
                            <!-- ============================================================== -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <footer class="footer text-center" style="padding-left: 250px;">
        <b>2024 © M.Kumarasamy College of Engineering All Rights Reserved.<br>
            Developed and Maintained by Technology Innovation Hub.</b>
    </footer>
    <!--Description id=problem-->
    <!-- Problem Description Modal -->

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Problem</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="rejectreason">
                    <div class="modal-body">
                        <p>Are you sure you want to reject this problem?</p>
                        <textarea name="reason" class="form-control" placeholder="Reason for rejection" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
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


    <!-- Before Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog"
        aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" alt="Image" class="img-fluid"
                        style="width: 100%; height: auto;">
                    <!-- src will be set dynamically -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Complaint Details Modal -->
    <div class="modal fade" id="complaintDetailsModal" tabindex="-1" role="dialog" aria-labelledby="complaintDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="border-radius: 8px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15); background-color: #f9f9f9;">

                <!-- Modal Header -->
                <div class="modal-header" style="background-color: #007bff; color: white; border-radius: 8px 8px 0 0; padding: 15px;">
                    <h5 class="modal-title" id="complaintDetailsModalLabel" style="font-weight: 700; font-size: 1.4em; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                        📋 Complaint Details
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; font-size: 1.2em;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body" style="padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

                    <!-- Complaint Info Section arranged in two-column layout -->
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #007bff;">Complaint ID</label>
                                <div class="text-muted"><b id="id"></b></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #007bff;">Faculty Infra Coordinator Name</label>
                                <div class="text-muted"><b id="faculty_name"></b></div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #007bff;">Mobile Number</label>
                                <div class="text-muted"><b id="faculty_contact"></b></div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #007bff;">E-mail</label>
                                <div class="text-muted"><b id="faculty_mail"></b></div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #007bff;">Faculty_name</label>
                                <div class="text-muted"><b id="fac_name"></b></div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #007bff;">Faculty_ID</label>
                                <div class="text-muted"><b id="fac_id"></b></div>
                            </div>
                        </div>

                        <!-- New row for Venue and Type of Problem -->
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #007bff;">Venue Name</label>
                                <div class="text-muted"><b id="venue_name"></b></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #007bff;">Type of Problem</label>
                                <div class="text-muted"><b id="type_of_problem"></b></div>
                            </div>
                        </div>

                        <!-- Full width for Problem Description -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #007bff;">Problem Description</label>
                                <div class="alert alert-light" role="alert" style="border-radius: 6px; background-color: #f1f1f1; padding: 15px; color: #333;">
                                    <span id="problem_description"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Modal Footer with Save Button -->
                <div class="modal-footer" style="background-color: #f1f1f1; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; padding: 10px;">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!------------------Pending Work Modal----------------->
    <div class="tab-pane p-20" id="home" role="tabpanel">
        <div class="modal fade" id="cmodal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);background-color:#7460ee;">
                        <h5 class="modal-title" id="exampleModalLabel">Raise Complaint</h5>
                        <button class="spbutton" type="button" class="btn-close" data-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div>
                        <form id="addnewuser" enctype="multipart/form-data" onsubmit="handleSubmit(event)">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <input type="hidden" id="hidden_faculty_id" name="faculty_id" value="<?php echo $faculty_id; ?>">
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
                                    <label for="block" class="form-label">Block <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="block_venue" placeholder="Eg:RK-206 / Transport:Bus No" required>
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
                                    <label for="description" class="form-label">Problem Description <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="problem_description" placeholder="Enter Description" required>
                                </div>

                                <div class="mb-3">
                                    <label for="itemno" class="form-label">Item Number(for electrical/itkm work)</label>
                                    <input type="text" class="form-control" name="itemno" placeholder="Eg: AC-102">
                                </div>
                                <div class="mb-3">
                                    <label for="images" class="form-label">Image(less than 2mb)<span style="color: red;">*</span> </label>
                                    <input type="file" class="form-control" name="images" id="images" onchange="validateSize(this)" required>
                                </div>
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" name="date_of_reg" id="date_of_reg" required>
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


        <!-- After Image Modal -->
        <div class="modal fade" id="afterImageModal" tabindex="-1" role="dialog"
            aria-labelledby="afterImageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="afterImageModalLabel">After Picture</h5>
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
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






        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




        <!-- End Wrapper -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- All Jquery -->
        <!-- ============================================================== -->



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
        <!--for data table-->
        <script src="assets/extra-libs/DataTables/datatables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" integrity="sha512-JnjG+Wt53GspUQXQhc+c4j8SBERsgJAoHeehagKHlxQN+MtCCmFDghX9/AcbkkNRZptyZU4zC8utK59M5L45Iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


        <!-- Set Today date in Raise Complaint-->
        <script>
            var today = new Date().toISOString().split('T')[0];
            var dateInput = document.getElementById('date_of_reg');
            dateInput.setAttribute('min', today);
            dateInput.setAttribute('max', today);
            dateInput.value = today;

            $(document).ready(function() {
                $('#feedbackTable').DataTable();
                $('#complaints_table').DataTable();


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
            $(function() {
                // Initialize the tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // You can also set options manually if needed
                $('.showImage1').tooltip({
                    placement: 'top',
                    title: 'Before'
                });
            });

            $(function() {
                // Initialize the tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // You can also set options manually if needed
                $('.imgafter').tooltip({
                    placement: 'top',
                    title: 'After'
                });
            });
            $(function() {
                // Initialize the tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // You can also set options manually if needed
                $('.viewcomplaint').tooltip({
                    placement: 'top',
                    title: 'View Complaint'
                });
            });

            $(function() {
                // Initialize the tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // You can also set options manually if needed
                $('.userreject').tooltip({
                    placement: 'top',
                    title: 'Reject'
                });
            });

            $(function() {
                // Initialize the tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // You can also set options manually if needed
                $('.userapprove').tooltip({
                    placement: 'top',
                    title: 'Accept'
                });
            });

            $(function() {
                // Initialize the tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // You can also set options manually if needed
                $('.showImage1').tooltip({
                    placement: 'top',
                    title: 'Before'
                });
            });
            $(function() {
                // Initialize the tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // You can also set options manually if needed
                $('.viewcomplaint').tooltip({
                    placement: 'top',
                    title: 'View Complaint'
                });
            });


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
                            $("#complaints_table").load(location.href + " #complaints_table > *", function() {
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