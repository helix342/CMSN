<?php
require 'config.php';
include("session.php");


if (!empty($fac_id)) {
    $faculty_id = $fac_id;
    $qrydata = "SELECT dept FROM faculty WHERE id = '$faculty_id'";
    $run = mysqli_query($db, $qrydata);
    $runs = mysqli_fetch_array($run);
    $dept = $runs['dept'];
} else {
}

$query = "SELECT * FROM complaints_detail WHERE faculty_id = '$faculty_id'";
$result = mysqli_query($db, $query);

$sql5 = "SELECT * FROM complaints_detail WHERE status IN (1,2,4,6,8,9,22) AND faculty_id = '$faculty_id'";
$sql1 = "SELECT * FROM complaints_detail WHERE status IN (7,10,17) AND faculty_id = '$faculty_id'";
$sql11 = "SELECT * FROM complaints_detail WHERE status IN (11,18,14) AND faculty_id = '$faculty_id'";
$sql2 = "SELECT * FROM complaints_detail WHERE status = 16 AND faculty_id = '$faculty_id'";
$sql3 = "SELECT * FROM complaints_detail WHERE status IN (23,5,19,20) AND faculty_id = '$faculty_id'";
$sql4 = "SELECT * FROM complaints_detail WHERE status = 15 AND faculty_id = '$faculty_id'";

$result5 = mysqli_query($db, $sql5);
$result1 = mysqli_query($db, $sql1);
$result11 = mysqli_query($db, $sql11);

$result2 = mysqli_query($db, $sql2);
$result3 = mysqli_query($db, $sql3);
$result4 = mysqli_query($db, $sql4);

$row_count5 = mysqli_num_rows($result5);
$row_count1 = mysqli_num_rows($result1);
$row_count11 = mysqli_num_rows($result11);

$row_count2 = mysqli_num_rows($result2);
$row_count3 = mysqli_num_rows($result3);
$row_count4 = mysqli_num_rows($result4);

if (isset($_POST['facdet'])) {
    $sql8 =  "SELECT * FROM faculty WHERE dept = '$dept'";
    $result8 = mysqli_query($db, $sql8);

    $options = '';
    $options .= '<option value="">Select a Faculty</option>';



    while ($row = mysqli_fetch_assoc($result8)) {
        $options .= '<option value="' . $row['id'] . '">' . $row['id'] . ' - ' . $row['name'] . '</option>';
    }


    echo $options;
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIC</title>
    <link rel="icon" type="image/png" sizes="32x32" href="image/icons/mkce_s.png">
    <link rel="stylesheet" href="../css/stylescms.css">
    <link href="../css/dboardstyles.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-5/bootstrap-5.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/alertify.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Rubik:wght@300;400;500;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

        <!-- Breadcrumb -->
        <div class="breadcrumb-area custom-gradient">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Work information</a></li>
                </ol>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="container-fluid">
            <div class="custom-tabs">
                <ul class="nav nav-tabs" role="tablist">
                    <!-- Center the main tabs -->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" id="edit-bus-tab" href="#dashboard" role="tab"
                            aria-selected="true">
                            <span class="hidden-xs-down" style="font-size: 0.9em;"><i class="bi bi-people-fill tab-icon"></i>
                                Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " data-bs-toggle="tab" id="edit-bus-tab" href="#home" role="tab" aria-selected="true">
                            <span class="hidden-xs-down" style="font-size: 0.9em;"><i class="bi bi-people-fill tab-icon"></i>
                                <i class="fas fa-exclamation"></i>
                                <b>&nbsp Complaints (<?php echo $row_count5; ?>)</b>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " data-bs-toggle="tab" id="edit-bus-tab" href="#inprogress" role="tab"
                            aria-selected="true">
                            <span class="hidden-xs-down" style="font-size: 0.9em;"><i class="bi bi-people-fill tab-icon"></i>
                                <i class="fas fa-clock"></i>
                                <b>&nbsp Feedback (<?php echo $row_count11; ?>)</b>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " data-bs-toggle="tab" id="edit-bus-tab" href="#completed" role="tab"
                            aria-selected="true">
                            <span class="hidden-xs-down" style="font-size: 0.9em;"><i class="bi bi-house-door tab-icon"></i>
                                <i class="mdi mdi-check-all"></i>
                                <b>&nbsp Completed Work (<?php echo $row_count2; ?>)</b>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " data-bs-toggle="tab" id="edit-bus-tab" href="#parents" role="tab" aria-selected="true">
                            <span class="hidden-xs-down" style="font-size: 0.9em;"><i class="bi bi-house-door-fill"></i>
                                <i class="mdi mdi-close-circle"></i>
                                <b>&nbsp Rejected Work (<?php echo $row_count3; ?>)</b>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " data-bs-toggle="tab" id="edit-bus-tab" href="#reassign" role="tab"
                            aria-selected="true">
                            <span class="hidden-xs-down" style="font-size: 0.9em;"><i class="bi bi-house-door-fill"></i>
                                <i class="fas fa-redo"></i>
                                <b>&nbsp Reassigned Work (<?php echo $row_count4; ?>)</b>
                            </span>
                        </a>
                    </li>

                </ul>
                <div class="tab-content">
                    <!-----------------------------------DashBoard---------------------------------------->
                    <div class="tab-pane p-20 active show" id="dashboard" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <div id="dashref">
                                    <div class="row">
                                        <div class="col-12 col-md-3 mb-3">
                                            <div class="cir">
                                                <div class="bo">
                                                    <div class="content1">
                                                        <div class="stats-box text-center p-3" style="background-color:rgb(252, 119, 71);">
                                                            <i class="fas fa-bell m-b-5 font-20"></i>
                                                            <h1 class="m-b-0 m-t-5"><?php echo $row_count5; ?></h1>
                                                            <small class="font-light">Pending</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3 mb-3">
                                            <div class="cir">
                                                <div class="bo">
                                                    <div class="content1">
                                                        <div class="stats-box text-center p-3" style="background-color:rgb(241, 74, 74);">
                                                            <i class="fas fa-exclamation m-b-5 font-16"></i>
                                                            <h1 class="m-b-0 m-t-5"><?php echo $row_count1; ?></h1>
                                                            <small class="font-light">work in progress</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3 mb-3">
                                            <div class="cir">
                                                <div class="bo">
                                                    <div class="content1">
                                                        <div class="stats-box text-center p-3" style="background-color:rgb(70, 160, 70);">
                                                            <i class="fas fa-check m-b-5 font-20"></i>
                                                            <h1 class="m-b-0 m-t-5"><?php echo $row_count2; ?></h1>
                                                            <small class="font-light">Completed</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3 mb-3">
                                            <div class="cir">
                                                <div class="bo">
                                                    <div class="content1">
                                                        <div class="stats-box text-center p-3" style="background-color: rgb(187, 187, 35);">
                                                            <i class="fas fa-redo m-b-5 font-20"></i>
                                                            <h1 class="m-b-0 m-t-5"><?php echo $row_count4; ?></h1>
                                                            <small class="font-light">Re-assigned</small>
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
                    <!---------------------------DashBoard Ends-------------------------->
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
                                                    <input type="hidden" id="hidden_faculty_id" value="<?php echo $faculty_id; ?>">
                                                </div>
                                                <?php

                                                if (!empty($fac_id)) {
                                                ?>

                                                    <input type="hidden" class="form-control" name="faculty_id" id="faculty_id"
                                                        value="<?php echo $faculty_id; ?>" readonly>

                                                <?php
                                                } elseif (!empty($sid)) {


                                                ?>
                                                    <input type="hidden" name="faculty_id" id="faculty_id" value="<?php echo $faculty_id; ?>">

                                                <?php
                                                }
                                                ?>

                                                <div class="mb-3">
                                                    <label for="type_of_problem" class="form-label">Type of Problem <span
                                                            style="color: red;">*</span></label>
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
                                                    <input type="text" class="form-control" name="block_venue"
                                                        placeholder="Eg:RK-206 / Transport:Bus No" required>
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
                                                    <label for="images" class="form-label">Image(less than 2mb)<span style="color: red;">*</span>
                                                    </label>
                                                    <input type="file" class="form-control" name="images" id="images"
                                                        onchange="validateSize(this)" required>
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
                        <!--pending work modal end -->

                        <!-- Pending table Start-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div id="raise_complaint" style="text-align: right;">


                                            <button type="button" class="btn btn-info float-right fac" data-toggle="modal"
                                                data-target="#cmodal">Raise Complaint</button>
                                            <br><br>


                                        </div>
                                        <div class="table-responsive">
                                            <table id="user" class="table table-bordered table-striped">
                                                <thead class="gradient-header">
                                                    <tr>
                                                        <th class="text-center"><b>S.No</b></th>
                                                        <th class="text-center"><b>Problem_id</b></th>
                                                        <th class="text-center"><b>Venue</b></th>
                                                        <th class="text-center"><b>Problem</b></th>
                                                        <th class="text-center"><b>Problem description</b></th>
                                                        <th class="text-center"><b>Date Of submission</b></th>
                                                        <th class="text-center"><b>Photo</b></th>
                                                        <th class="text-center"><b>Status</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $s = 1;
                                                    while ($row = mysqli_fetch_assoc($result5)) {
                                                        $statusMessage = '';
                                                        switch ($row['status']) {
                                                            case 1:
                                                                $statusMessage = 'Pending';
                                                                break;
                                                            case 2:
                                                                $statusMessage = 'Forwarded to Faculty Infra Coordinator';
                                                                break;
                                                            case 4:
                                                                $statusMessage = 'Forwarded to Estate Officer';
                                                                break;
                                                            case 6:
                                                                $statusMessage = 'Forwarded to Principal';
                                                                break;
                                                            case 8:
                                                                $statusMessage = 'Approved by Principal ';
                                                                break;
                                                            case 9:
                                                                $statusMessage = ' Approved by Manager';
                                                                break;
                                                            case 22:
                                                                $statusMessage = ' Forwarded to Manager';
                                                                break;
                                                            default:
                                                                $statusMessage = 'Unknown Status';
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $s; ?></td>
                                                            <td class="text-center"><?php echo $row['id']; ?></td>
                                                            <td class="text-center"><?php echo $row['block_venue']; ?></td>
                                                            <td class="text-center"><?php echo $row['type_of_problem']; ?></td>
                                                            <td class="text-center"><?php echo $row['problem_description']; ?></td>
                                                            <td class="text-center"><?php echo $row['date_of_reg']; ?></td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-light btn-sm showImage"
                                                                    value="<?php echo $row['id']; ?>">
                                                                    <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php if ($row['status'] == 1) { ?>
                                                                    <center>
                                                                        <button class="btn btndelete btn-danger" type="button"
                                                                            value="<?php echo $row['id']; ?>">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>
                                                                    </center>
                                                                <?php } else { ?>


                                                                    <span class="badge bg-success"
                                                                        style="font-size: 1.2em; color: white; padding: 0.25em 0.5em;"><?php echo $statusMessage; ?></span>
                                                                <?php } ?>
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
                    <?php
                    $s = 1;
                    while ($row = mysqli_fetch_assoc($result5)) {
                        $statusMessage = '';
                        switch ($row['status']) {
                            case 1:
                                $statusMessage = 'Pending';
                                break;
                            case 2:
                                $statusMessage = 'Approved by Faculty Infra Coordinator';
                                break;
                            case 4:
                                $statusMessage = 'Approved by HOD';
                                break;
                            case 6:
                                $statusMessage = 'Sent to Principal for Approval';
                                break;
                            case 8:
                                $statusMessage = 'Approved by Principal ';
                                break;
                            case 9:
                                $statusMessage = ' Approved by Manager';
                                break;
                            default:
                                $statusMessage = 'Unknown Status';
                        }
                    }
                    ?>



                    <!------------------Complain form Page Ends----------------->





                    <!------------------Work in Progress Starts----------------->
                    <div class="tab-pane p-20" id="inprogress" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="ProgressTable" class="table table-bordered table-striped">
                                        <thead class="gradient-header">
                                            <tr>
                                                <th class="text-center"><b>S.No</b></th>
                                                <th class="text-center"><b>Problem_id</th>
                                                <th class="text-center"><b>Venue</b></th>
                                                <th class="text-center"><b>Problem description</b></th>
                                                <th class="text-center"><b>Date Of submission</b></th>
                                                <th class="text-center"><b>Deadline</b></th>
                                                <th class="text-center"><b>Worker Details</b></th>
                                                <th class="text-center"><b>Status</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $s = 1;
                                            while ($row = mysqli_fetch_assoc($result1)) {
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $s; ?></td>
                                                    <td class="text-center"><?php echo $row['id']; ?></td>
                                                    <td class="text-center"><?php echo $row['block_venue']; ?></td>
                                                    <td class="text-center"><?php echo $row['problem_description']; ?></td>
                                                    <td class="text-center"><?php echo $row['date_of_reg']; ?></td>
                                                    <td class="text-center">
                                                        <?php if ($row['extend_date'] == 1) { ?>
                                                            <button type="button" class="btn btn-danger extenddeadline" id="extendbutton"
                                                                value="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#extendModal"
                                                                data-reason="<?php echo $row['extend_reason']; ?>">
                                                                <?php echo $row['days_to_complete']; ?>
                                                            </button>
                                                        <?php } else { ?>
                                                            <?php echo $row['days_to_complete']; ?>
                                                        <?php } ?>
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
                                                        In Progress
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
                    <!------------------FeedBack Table----------------->
                    <div class="tab-pane p-20" id="waitfeed" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="feedbackTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center"><b>S.No</b></th>
                                                <th class="text-center"><b>Problem_idb></th>
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
                                                            <button type="button" class="btn btn-danger extenddeadline" id="extendbutton"
                                                                value="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#extendModal"
                                                                data-reason="<?php echo $row['extend_reason']; ?>">
                                                                <?php echo $row['days_to_complete']; ?>
                                                            </button>
                                                        <?php } else { ?>
                                                            <?php echo $row['days_to_complete']; ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <button value="<?php echo $row['id']; ?>" type="button" class="btn btn-light btn-sm imgafter"
                                                            data-toggle="modal">
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


                    <!-- Extend Modal -->
                    <div class="modal fade" id="extendModal" tabindex="-1" role="dialog" aria-labelledby="extendModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header"
                                    style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);background-color:#7460ee;">
                                    <h5 class="modal-title" id="exampleModalLabel">Deadline Extended</h5>
                                    <button class="spbutton" type="button" class="btn-close" data-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="rejectForm">
                                        <input type="hidden" name="id" id="complaint_id99">
                                        <div class="form-group">
                                            <label for="rejectReason" class="form-label">Reason for
                                                Deadline Extension:</label> <br>
                                            <br>
                                            <textarea id="extendReasonTextarea" readonly
                                                style="width: 100%; height: 80px; font-size: 14px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9; color: #333; resize: none; overflow-y: auto;"></textarea>


                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!------------------Work in Progress Table Ends----------------->


                    <!-- Worker Details Modal -->
                    <div class="modal fade" id="workerModal" tabindex="-1" aria-labelledby="workerModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header"
                                    style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);background-color:#7460ee;">
                                    <h5 class="modal-title" id="exampleModalLabel">Worker Phone</h5>
                                    <button class="spbutton" type="button" class="btn-close" data-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="box"
                                        style="background-color: #f7f7f7; border: 1px solid #ccc; padding: 15px; margin-bottom: 10px; border-radius: 5px;">
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
                    <div class="modal fade" id="feedback_modal" tabindex="-1" aria-labelledby="feedbackModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header"
                                    style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);background-color:#7460ee;">
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
                                            <textarea name="feedback" id="feedback" class="form-control" placeholder="Enter Feedback"
                                                style="width: 100%; height: 150px;"></textarea>
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


                    <!----------------Completed Work Table starts--------------------->
                    <div class="tab-pane p-20" id="completed" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="completedTable" class="table table-bordered table-striped">
                                        <thead class="gradient-header">
                                            <tr>
                                                <th class="text-center"><b>S.No</b></th>
                                                <th class="text-center"><b>Problem_id</b></th>
                                                <th class="text-center"><b>Venue</b></th>
                                                <th class="text-center"><b>Problem</b></th>
                                                <th class="text-center"><b>Date Of submission</b></th>
                                                <th class="text-center"><b>Date of Completion</b></th>
                                                <th class="text-center"><b>Feedback</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $s = 1;
                                            while ($row = mysqli_fetch_assoc($result2)) {
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $s; ?></td>
                                                    <td class="text-center"><?php echo $row['id']; ?></td>
                                                    <td class="text-center"><?php echo $row['block_venue']; ?></td>
                                                    <td class="text-center"><?php echo $row['problem_description']; ?></td>
                                                    <td class="text-center"><?php echo $row['date_of_reg']; ?></td>
                                                    <td class="text-center"><?php echo $row['date_of_completion']; ?></td>
                                                    <td class="text-center"><?php echo $row['feedback']; ?></td>
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


                    <!-- After Image Modal -->
                    <div class="modal fade" id="afterImageModal" tabindex="-1" role="dialog"
                        aria-labelledby="afterImageModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header"
                                    style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);background-color:#7460ee;">
                                    <h5 class="modal-title" id="exampleModalLabel">After Image</h5>
                                    <button class="spbutton" type="button" class="btn-close" data-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img id="modalImage2" src="" alt="After" class="img-fluid">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---------------------Completed Work Table Ends------------------------------>


                    <!-- Before Image Modal -->
                    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header"
                                    style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);background-color:#7460ee;">
                                    <h5 class="modal-title" id="exampleModalLabel">Before Image</h5>
                                    <button class="spbutton" type="button" class="btn-close" data-dismiss="modal"
                                        aria-label="Close"></button>
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




                    <!-----------------------Rejected Work Table Starts-------------------------->
                    <div class="tab-pane p-20" id="parents" role="tabpanel">
                        <div class="table-responsive">
                            <table id="RejectionTable" class="table table-bordered table-striped">
                                <thead class="gradient-header">
                                    <tr>
                                        <th class="text-center"><b>S.No</b></th>
                                        <th class="text-center"><b>Problem_id</b></th>
                                        <th class="text-center"><b>Block</b></th>
                                        <th class="text-center"><b>Venue</b></th>
                                        <th class="text-center"><b>problem description</b></th>
                                        <th class="text-center"><b>Status </b></th>
                                        <th class="text-center"><b>Reason </b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $s = 1;
                                    while ($row = mysqli_fetch_assoc($result3)) {
                                        $statusMessage = '';
                                        switch ($row['status']) {
                                            case 3:
                                                $statusMessage = 'Rejected by Faculty Infra Coordinator';
                                                break;
                                            case 5:
                                                $statusMessage = 'Rejected by HOD';
                                                break;
                                            case 23:
                                                $statusMessage = 'Rejected by EO';
                                                break;
                                            case 19:
                                                $statusMessage = 'Rejected by Principal';
                                                break;
                                            case 20:
                                                $statusMessage = 'Rejected by Manager';
                                                break;
                                            default:
                                                $statusMessage = 'Unknown Status';
                                        }
                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $s; ?></td>
                                            <td class="text-center"><?php echo $row['id']; ?></td>
                                            <td class="text-center"><?php echo $row['block_venue']; ?></td>
                                            <td class="text-center"><?php echo $row['venue_name']; ?></td>
                                            <td class="text-center"><?php echo $row['problem_description']; ?></td>
                                            <td class="text-center">
                                                <span class="badge"
                                                    style="background-color: #ff6666; font-size: 1.2em; color: white; padding: 0.25em 0.5em;"><?php echo $statusMessage; ?></span>
                                            </td>
                                            <td class="text-center"><?php echo $row['feedback']; ?></td>
                                        </tr>
                                    <?php
                                        $s++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!------------------Rejected Work Table Ends----------------->


                    <!------------------Reassigned work Table Starts----------------->
                    <div class="tab-pane p-20" id="reassign" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="reassignTable" class="table table-bordered table-striped">
                                        <thead class="gradient-header">
                                            <tr>
                                                <th class="text-center"><b>S.No</b></th>
                                                <th class="text-center"><b>Problem_id</b></th>
                                                <th class="text-center"><b>Venue</b></th>
                                                <th class="text-center"><b>Problem</b></th>
                                                <th class="text-center"><b>Problem description</b></th>
                                                <th class="text-center"><b>Date Of submission</b></th>
                                                <th class="text-center"><b>Worker Details</b></th>
                                                <th class="text-center"><b>Feedback</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $s = 1;
                                            while ($row = mysqli_fetch_assoc($result4)) {
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $s; ?></td>
                                                    <td class="text-center"><?php echo $row['id']; ?></td>
                                                    <td class="text-center"><?php echo $row['block_venue']; ?></td>
                                                    <td class="text-center"><?php echo $row['type_of_problem']; ?></td>
                                                    <td class="text-center"><?php echo $row['problem_description']; ?></td>
                                                    <td class="text-center"><?php echo $row['date_of_reg']; ?></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-info showWorkerDetails"
                                                            value="<?php echo $row['id']; ?>">View</button>
                                                    </td>
                                                    <td><?php echo $row['feedback']; ?></td>
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
    <!-- Bootstrap 4 Tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Perfect Scrollbar -->
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <!-- Sparkline -->
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <!-- Wave Effects -->
    <script src="dist/js/waves.js"></script>
    <!-- Sidebar Menu -->
    <script src="dist/js/sidebarmenu.js"></script>
    <!-- Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>

    <!-- Charts and Analytics -->
    <script src="assets/libs/flot/excanvas.js"></script>
    <script src="assets/libs/flot/jquery.flot.js"></script>
    <script src="assets/libs/flot/jquery.flot.pie.js"></script>
    <script src="assets/libs/flot/jquery.flot.time.js"></script>
    <script src="assets/libs/flot/jquery.flot.stack.js"></script>
    <script src="assets/libs/flot/jquery.flot.crosshair.js"></script>
    <script src="assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="dist/js/pages/chart/chart-page-init.js"></script>

    <!-- SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


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
    </script>


    <script>
        // DataTables
        $(document).ready(function() {
            $('#user').DataTable();
            $('#ProgressTable').DataTable();
            $('#completedTable').DataTable();
            $('#RejectionTable').DataTable();
            $('#reassignTable').DataTable();
            $('#feedbackTable').DataTable();

        });
    </script>


    <script>
        // Add Faculty complaints to database
        $(document).on('submit', '#addnewuser', function(e) {
            e.preventDefault(); // Prevent form from submitting normally
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: 'cms_backend.php?action=facraisecomp',
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


        // Delete complaints given by faculty
        $(document).on('click', '.btndelete', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this data?')) {
                var user_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: 'cms_backend.php?action=facdelcomp',
                    data: {
                        'user_id': user_id
                    },
                    success: function(response) {
                        console.log(response);
                        var res = typeof response === 'string' ? JSON.parse(response) : response;
                        if (res.status === 500) {
                            alert(res.message);
                        } else {
                            swal("Complaint deleted successfully", "", "success");
                            $('#navref1').load(location.href + " #navref1");
                            $('#navref2').load(location.href + " #navref2");
                            $('#navref3').load(location.href + " #navref3");
                            $('#dashref').load(location.href + " #dashref");
                            $('#raise_complaint').load(location.href + " #raise_complaint");

                            $('#user').DataTable().destroy();
                            $("#user").load(location.href + " #user > *", function() {
                                $('#user').DataTable();
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX Error:", textStatus, errorThrown);
                        alert("Failed to delete data.");
                    }
                });
            }
        });



        //Before image
        $(document).on("click", ".showImage", function() {
            var problem_id = $(this).val(); // Get the problem_id from button value
            console.log(problem_id); // Ensure this logs correctly
            $.ajax({
                type: "POST",
                url: 'cms_backend.php?action=facbimg',
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
                        $('#navref6').load(location.href + " #navref6");
                        $('#navref33').load(location.href + " #navref33");

                        $('#dashref').load(location.href + " #dashref");

                        $('#ProgressTable').DataTable().destroy();
                        $("#ProgressTable").load(location.href + " #ProgressTable > *", function() {
                            $('#ProgressTable').DataTable();
                        });

                        $('#feedbackTable').DataTable().destroy();
                        $("#feedbackTable").load(location.href + " #feedbackTable > *", function() {
                            $('#feedbackTable').DataTable();
                        });

                        $('#completedTable').DataTable().destroy();
                        $("#completedTable").load(location.href + " #completedTable > *", function() {
                            $('#completedTable').DataTable();
                        });

                        $('#reassignTable').DataTable().destroy();
                        $("#reassignTable").load(location.href + " #reassignTable > *", function() {
                            $('#reassignTable').DataTable();
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
    </script>

    <script>
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


        $(document).on('click', '.fac', function(e) {
            e.preventDefault();

            $.ajax({
                url: 'completedtable.php',
                type: "POST",
                data: {
                    'facdet': true,
                },
                success: function(response) {
                    console.log(response);
                    $('#cfaculty').html(response);
                }
            });
        });

        $(document).on("click", ".limitovr", function(e) {
            e.preventDefault();
            swal("Warning!", "You have crossed your complaint limit!", "warning");
        })


        $(document).on('click', '.extenddeadline', function() {
            // Get the reason from the button's data attribute
            var reason = $(this).data('reason');

            // Set the reason in the modal's textarea
            $('#extendReasonTextarea').val(reason);
        });

        $(document).on("submit", "#passwordform", function(e) {
            e.preventDefault();
            var formdata = new FormData(this);
            console.log(formdata);
            console.log("hii");
            $.ajax({
                type: "POST",
                url: 'cms_backend.php?action=facchangepass',
                data: formdata,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    var res = jQuery.parseJSON(response);
                    if (res.status == 200) {
                        $('#passmodal').modal('hide');
                        swal("Done!", "Password Changed!", "success");
                    } else {
                        alert('error');
                    }
                }
            })
        })
    </script>
</body>
<div scrible-ignore="" id="skribel_annotation_ignore_browserExtensionFlag" class="skribel_chromeExtension"
    style="display: none"></div>


</html>