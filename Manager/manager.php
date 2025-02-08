<?php
require "config.php";
// include("session.php");
// $role = $frole;
// if ($role !== "Manager") {
//     header("Location:index.php");
// }
//query for 1st table input 
//Faculty complaint table
$sql1 = "
SELECT cd.*, f.name, f.dept
FROM complaints_detail cd
JOIN faculty f ON cd.faculty_id = f.id
WHERE cd.status IN ('22', '9')
ORDER BY 
    CASE WHEN f.id = 'principal' THEN 0 ELSE 1 END, 
    cd.status = '9'
";

$result1 = mysqli_query($db, $sql1);
$row_count1 = mysqli_num_rows($result1);
//manager table
$sql2 = "SELECT * FROM worker_details";
$result2 = mysqli_query($db, $sql2);
//worker details fetch panna
$sql3 = "SELECT * FROM complaints_detail WHERE status IN ('9','10','11')";
$result3 = mysqli_query($db, $sql3);
$row_count3 = mysqli_num_rows($result3);

//worker details fetch panna
$sql4 = "SELECT * FROM complaints_detail WHERE status IN ('8','19')";
$result4 = mysqli_query($db, $sql4);

$sql9 = "SELECT * FROM complaints_detail WHERE status IN ('8')";
$result9 = mysqli_query($db, $sql9);
$row_count4 = mysqli_num_rows($result9);

//work finished table
$sql5 = "SELECT * FROM complaints_detail WHERE status = '14'";
$result5 = mysqli_query($db, $sql5);
$row_count5 = mysqli_num_rows($result5);
//work completed table
$sql6 = "SELECT * FROM complaints_detail WHERE status='16'";
$result6 = mysqli_query($db, $sql6);
$row_count2  = mysqli_num_rows($result6);
//work reassigned table
$sql7 = "SELECT * FROM complaints_detail WHERE status IN ('15','17','18')";
$result7 = mysqli_query($db, $sql7);
$row_count7 = mysqli_num_rows($result7);

//display all users
$sql10 = "SELECT * FROM faculty_details";
$result10 = mysqli_query($db, $sql10);

//display all workers
$sql11 = "SELECT * FROM worker_details";
$result11 = mysqli_query($db, $sql11);


if (isset($_POST['fdept'])) {
    $fdept = "SELECT * FROM departments";
    $fdept_run = mysqli_query($db, $fdept);
    $options = '';


    while ($row = mysqli_fetch_assoc($fdept_run)) {
        $options .= '<option value="' . $row['dname'] . '">' . $row['dname'] . '</option>';
    }
    echo $options;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIC</title>
    <link rel="icon" type="image/png" sizes="32x32" href="image/icons/mkce_s.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="assets/css/tabs.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/segoe-ui/1.0.0/segoe-ui.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-5/bootstrap-5.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
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
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Research</li>
                </ol>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="container-fluid" id="container">
            <div class="container">
                <div class="custom-tabs">
                    <!-- Navigation Tabs -->
                    <ul class="nav nav-tabs" id="navref" role="tablist">
                        <!-- Tab 1: Dashboard -->
                        <li class="nav-item" id="nav1" role="presentation">
                            <button class="nav-link active" id="add-bus-tab" data-bs-toggle="tab"
                                data-bs-target="#dashboard" type="button" role="tab">
                                <i class="fas fa-exclamation-circle tab-icon"></i>Dashboard
                            </button>
                        </li>
                        <!-- Tab 2: Complaint Raised -->
                        <li class="nav-item" id="nav2" role="presentation">
                            <button class="nav-link" id="edit-bus-tab" data-bs-toggle="tab"
                                data-bs-target="#complaint-raised" type="button" role="tab">
                                <i class="fas fa-exclamation-circle tab-icon"></i>Raised (<?php echo $row_count1; ?>)
                            </button>
                        </li>

                        <!-- Tab 3: Principal Approval -->
                        <li class="nav-item" id="nav3" role="presentation">
                            <button class="nav-link" id="schedule-bus-tab" data-bs-toggle="tab"
                                data-bs-target="#principal-approval" type="button" role="tab">
                                <i class="fas fa-user-check tab-icon"></i>Principal (<?php echo $row_count4; ?>)
                            </button>
                        </li>

                        <!-- Tab 4: Assigned -->
                        <li class="nav-item" id="nav4" role="presentation">
                            <button class="nav-link" id="route-bus-tab" data-bs-toggle="tab" data-bs-target="#assigned"
                                type="button" role="tab">
                                <i class="fas fa-tasks tab-icon"></i>Assigned (<?php echo $row_count3; ?>)
                            </button>
                        </li>

                        <!-- Tab 5: Response -->
                        <li class="nav-item" id="nav5" role="presentation">
                            <button class="nav-link" id="maintenance-bus-tab" data-bs-toggle="tab"
                                data-bs-target="#response" type="button" role="tab">
                                <i class="fas fa-reply tab-icon"></i>Response (<?php echo $row_count5; ?>)
                            </button>
                        </li>

                        <!-- Tab 6: Reassigned -->
                        <li class="nav-item" id="nav6" role="presentation">
                            <button class="nav-link" id="history-bus-tab" data-bs-toggle="tab"
                                data-bs-target="#reassigned" type="button" role="tab">
                                <i class="fas fa-exchange-alt tab-icon"></i>Reassigned (<?php echo $row_count7; ?>)
                            </button>
                        </li>

                        <!-- Tab 7: Completed Works -->
                        <li class="nav-item" id="nav7" role="presentation">
                            <button class="nav-link" id="update-bus-tab" data-bs-toggle="tab"
                                data-bs-target="#completed-works" type="button" role="tab">
                                <i class="fas fa-check-circle tab-icon"></i>Completed
                            </button>
                        </li>

                        <!-- Tab 8: Work Record -->
                        <li class="nav-item" id="nav8" role="presentation">
                            <button class="nav-link" id="fleet-management-bus-tab" data-bs-toggle="tab"
                                data-bs-target="#work-record" type="button" role="tab">
                                <i class="fas fa-clipboard-list tab-icon"></i>Record
                            </button>
                        </li>

                        <!-- Tab 9: Workers Record -->
                        <li class="nav-item" id="nav9" role="presentation">
                            <button class="nav-link" id="report-bus-tab" data-bs-toggle="tab"
                                data-bs-target="#workers-record" type="button" role="tab">
                                <i class="fas fa-users tab-icon"></i>Workers
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Dashboard card starts  -->
                        <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="mb-0">Issue Analysis</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <!-- Pending -->
                                                <div class="col-12 col-md-3" style="margin-bottom: 40px">
                                                    <div class="cir">
                                                        <div class="bo">
                                                            <div class="content1">
                                                                <div class="stats-box text-center p-3"
                                                                    style="background-color:orange;">
                                                                    <i class="fas fa-clock"></i>
                                                                    <h1 class="font-light text-white">
                                                                        <?php echo $row_count1; ?>
                                                                    </h1>
                                                                    <small class="font-light">New Issues</small>
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
                                                                <div class="stats-box text-center p-3"
                                                                    style="background-color:rgb(14, 86, 239);">
                                                                    <i class="fas fa-check"></i>
                                                                    <h1 class="font-light text-white">
                                                                        <?php echo $row_count3; ?>
                                                                    </h1>
                                                                    <small class="font-light">Pending</small>
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
                                                                    <h1 class="font-light text-white">
                                                                        <?php echo $row_count2; ?>
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
                                                                <div class="stats-box text-center p-3"
                                                                    style="background-color:red;">
                                                                    <i class="fas fa-exclamation"></i>
                                                                    <h1 class="font-light text-white">
                                                                        <?php echo $row_count7; ?>
                                                                    </h1>
                                                                    <small class="font-light">Reassigned</small>
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
                        <!-- Dashboard card ends  -->
                        <!--complaintTable card starts  -->
                        <div class="tab-pane fade" id="complaint-raised" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="mb-0">Complaint Raised</h4>
                                            <div class="dropdown">
                                                <div class="nav-item dropdown">
                                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                                        id="userDropdown" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fas fa-user-plus"></i>&nbsp;&nbsp;Manage
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="userDropdown">
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#manageworkermodal">
                                                                <i class="ti-user me-2"></i>Manager Worker
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item fetchdept" href="javascript:void(0)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#manageusermodal">
                                                                <i class="ti-user me-2"></i>Manager User
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">

                                                <!--complaintTable starts  -->
                                                <table id="complaintTable"
                                                    class="table table-striped table-bordered custom-table">
                                                    <thead class="table-class">
                                                        <tr>
                                                            <th><b>S.No</b></th>
                                                            <th><b>Date</b></th>
                                                            <th><b>Department/Venue</b></th>
                                                            <th><b>Complaint</b></th>
                                                            <th><b>Image</b></th>
                                                            <th><b>Action</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                    $s = 1;
                                                    while ($row = mysqli_fetch_assoc($result1)) {
                                                    ?>
                                                        <?php
                                                        if ($row['faculty_id'] == "principal") {


                                                        ?>
                                                        <tr style="background-color:#f3f57a ">
                                                            <?php
                                                        }
                                                            ?>
                                                            <?php
                                                            if ($row['faculty_id'] != "principal") {


                                                            ?>
                                                        <tr>
                                                            <?php
                                                            }
                                                            ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $s ?></td>
                                                            <td class="text-center"><?php echo $row['date_of_reg'] ?></td>
                                                            <td class="text-center"><?php echo $row['dept'] ?> /
                                                            <?php echo $row['block_venue'] ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-info viewcomplaint"
                                                                    title="Complaint Detail" data-bs-toggle="modal"
                                                                    data-bs-target="#complaintDetailsModal"
                                                                    value="<?php echo $row['id']; ?>" data-value="<?php echo $row['fac_id']; ?>">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-info  showImage"
                                                                    title="Complaint Image" data-bs-toggle="modal"
                                                                    data-bs-target="#imageModal" value="<?php echo $row['id']; ?>">
                                                                    <i class="fas fa-image"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="d-flex gap-2 justify-content-center">
                                                                <?php if ($row['status'] == 9) { ?>
                                                                    <div class="dropdown">
                                                                        <button type="button"
                                                                            class="btn btn-warning reassign dropdown-toggle"
                                                                            title="Reassign" id="reassignDropdown"
                                                                            value="<?php echo $row['id']; ?>"
                                                                            data-bs-toggle="dropdown"
                                                                            aria-expanded="false">
                                                                            Reassign
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            <li><a class="dropdown-item reass1" href="#"
                                                                                    data-value="electrical">Electrical</a>
                                                                            </li>
                                                                            <li><a class="dropdown-item reass1" href="#"
                                                                                    data-value="civil">Civil</a></li>
                                                                            <li><a class="dropdown-item reass1" href="#"
                                                                                    data-value="itkm">ITKM</a></li>
                                                                            <li><a class="dropdown-item reass1" href="#"
                                                                                    data-value="transport">Transport</a>
                                                                            </li>
                                                                            <li><a class="dropdown-item reass1" href="#"
                                                                                    data-value="house">House
                                                                                    Keeping</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <?php } else { ?>
                                                                    <button type="button"
                                                                        class="btn btn-success managerapprove"
                                                                        title="Approve" data-bs-toggle="dropdown"
                                                                        value="<?php echo $row['id']; ?>">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <center>
                                                                            <li><a href="#" class="worker"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#managerapproveModal"
                                                                                    data-value="electrical">ELECTRICAL</a>
                                                                            </li>
                                                                            <li><a href="#" class="worker"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#managerapproveModal"
                                                                                    data-value="civil">CIVIL</a></li>
                                                                            <li><a href="#" class="worker"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#managerapproveModal"
                                                                                    data-value="itkm">ITKM</a></li>
                                                                            <li><a href="#" class="worker"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#managerapproveModal"
                                                                                    data-value="transport">TRANSPORT</a>
                                                                            </li>
                                                                            <li><a href="#" class="worker"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#managerapproveModal"
                                                                                    data-value="house">HOUSE
                                                                                    KEEPING</a></li>
                                                                        </center>
                                                                    </ul>
                                                                    <button type="button"
                                                                        class="btn btn-danger  rejectcomplaint"
                                                                        id="rejectbutton" data-bs-toggle="modal"
                                                                        data-bs-target="#rejectModal"
                                                                        value="<?php echo $row['id']; ?>">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                    <?php
                                                                    if ($row['faculty_id'] == "principal") {
                                                                    ?>
                                                                    <button type="button"
                                                                        class="btn btn-primary  principalcomplaint"
                                                                        title="Principal Approval" id="principalbutton"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#principalModal"
                                                                        value="<?php echo $row['id']; ?>">
                                                                        <i class="fas fa-paper-plane"></i>
                                                                    </button>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <?php
                                                                    if ($row['faculty_id'] != "principal") {
                                                                    ?>
                                                                    <button type="button"
                                                                            class="btn btn-primary principalcomplaint"
                                                                            id="principalbutton" value="<?php echo $row['id']; ?>"
                                                                            data-toggle="modal" data-target="#principalModal"><i
                                                                                class="fas fa-paper-plane"></i>
                                                                        </button>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                <?php } ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $s++;
                                                    }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <!--complaintTable starts  -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--complaintTable card ends  -->

                        <!--principalApprovalTable card starts  -->
                        <div class="tab-pane fade" id="principal-approval" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="mb-0">Principal Approval</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">

                                                <!--principalApprovalTable  starts  -->
                                                <table id="principalApprovalTable"
                                                    class="table table-striped table-bordered custom-table">
                                                    <thead class="table-class">
                                                        <tr>
                                                            <th><b>S.No</b></th>
                                                            <th><b>Date</b></th>
                                                            <th><b>Venue</b></th>
                                                            <th><b>Complaint</b></th>
                                                            <th><b>Picture</b></th>
                                                            <th><b>Action</b></th>
                                                            <th><b>Status</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $s = 1; @endphp
                                                        @foreach ($complaints as $complaint)
                                                        <tr>
                                                            <td class="text-center">{{ $s }}</td>
                                                            <td class="text-center">{{ $complaint->date_of_reg }}</td>
                                                            <td class="text-center">{{ $complaint->block_venue }}</td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-info viewcomplaint"
                                                                    title="Complaint Detail" data-bs-toggle="modal"
                                                                    data-bs-target="#complaintDetailsModal"
                                                                    value="{{ $complaint->id }}"
                                                                    data-value="{{ $complaint->fac_id }}">
                                                                    <i class="fas fa-eye"></i>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-info  showImage"
                                                                    title="Complaint Image" data-bs-toggle="modal"
                                                                    data-bs-target="#imageModal"
                                                                    data-id="{{ $complaint->id }}">
                                                                    <i class="fas fa-image"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                @if ($complaint->status == 8)
                                                                <button type="button"
                                                                    class="btn btn-success managerapprove"
                                                                    title="Approve" data-bs-toggle="dropdown"
                                                                    value="{{ $complaint->id }}">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <center>
                                                                        <li><a href="#" class="worker"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#managerapproveModal"
                                                                                data-value="electrical">ELECTRICAL</a>
                                                                        </li>
                                                                        <li><a href="#" class="worker"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#managerapproveModal"
                                                                                data-value="civil">CIVIL</a></li>
                                                                        <li><a href="#" class="worker"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#managerapproveModal"
                                                                                data-value="itkm">ITKM</a></li>
                                                                        <li><a href="#" class="worker"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#managerapproveModal"
                                                                                data-value="transport">TRANSPORT</a>
                                                                        </li>
                                                                        <li><a href="#" class="worker"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#managerapproveModal"
                                                                                data-value="house">HOUSE
                                                                                KEEPING</a></li>
                                                                    </center>
                                                                </ul>
                                                                @elseif ($complaint->status == 19)
                                                                <button type="button"
                                                                    class="btn btn-primary update-status"
                                                                    value="{{ $complaint->id }}">
                                                                    Okay
                                                                </button>

                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                @if ($complaint->status == 8)
                                                                <span class="btn btn-success">Approved</span>
                                                                @elseif ($complaint->status == 19)
                                                                <button type="button"
                                                                    class="btn btn-danger rejectreasonbtn"
                                                                    value="{{ $complaint->id }}" data-bs-toggle="modal"
                                                                    data-bs-target="#princerejectres">Rejected</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @php $s++; @endphp
                                                        @endforeach
                                                    </tbody>
                                                    <!--principalApprovalTable  ends  -->

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--principalApprovalTable card ends  -->

                        <!--assignedTable card starts  -->
                        <div class="tab-pane fade" id="assigned" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="mb-0">Manager Assigned</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">

                                                <!--assignedTable starts  -->
                                                <table id="assignedTable"
                                                    class="table table-striped table-bordered custom-table">
                                                    <thead class="table-class">
                                                        <tr>
                                                            <th class="text-center"><b>S.No</b></th>
                                                            <th class="text-center"><b>Complaint</b></th>
                                                            <th class="text-center"><b>Worker</b></th>
                                                            <th class="text-center"><b>Deadline</b></th>
                                                            <th class="text-center"><b>Picture</b></th>
                                                            <th class="text-center"><b>Status</b></th>
                                                            <th class="text-center"><b>Principal Query</b></th>
                                                            <th class="text-center"><b>Your Reply</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                        $assserialNo = 1;
                                                        @endphp
                                                        @foreach ($assignedcomplaint as $complaint)
                                                        <tr>
                                                            <td class="text-center">{{ $assserialNo++ }}</td>
                                                            <td class="text-center">
                                                                <button type="button"
                                                                    value="{{ $complaint['complaint']->id }}"
                                                                    class="btn btn-info viewcomplaint"
                                                                    data-bs-toggle="modal"
                                                                    data-value="{{ $complaint['complaint']->fac_id }}"
                                                                    data-bs-target="#complaintDetailsModal">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center"><button type="button"
                                                                    class="btn btn-light worker_det"
                                                                    value="{{ $complaint['complaint']->id }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#workerdetailmodal">
                                                                    {{ $complaint['worker_name'] }}</td>
                                                            <td class="text-center">
                                                                <button class="btn btn-light deadline_extend"
                                                                    value="{{ $complaint['complaint']->id }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#extend_date">
                                                                    {{ \Carbon\Carbon::parse($complaint['deadline'])->format('d/m/Y') }}
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button"
                                                                    value="{{ $complaint['complaint']->id }}"
                                                                    class="btn btn-info showImage"
                                                                    data-bs-toggle="modal" data-bs-target="#imageModal">
                                                                    <i class="fas fa-image"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center"><span class="btn btn-warning">In
                                                                    Progress</span></td>
                                                            <td class="text-center">
                                                                <button type="button"
                                                                    class="btn btn-success openQueryModal"
                                                                    data-task-id="{{ $complaint['task_id'] }}"
                                                                    data-comment-query="{{ $complaint['comment_query'] }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#principalQueryModal">
                                                                    View Query
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                @if (!empty($complaint['comment_reply']))
                                                                <span>{{ $complaint['comment_reply'] }}</span>
                                                                <br>
                                                                <span class="">Reply Date:
                                                                    {{ \Carbon\Carbon::parse($complaint['reply_date'])->format('d/m/Y') }}</span>
                                                                @else
                                                                <span class="badge badge-secondary">No Reply Yet</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <!--assignedTable ends  -->

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--assignedTable card ends  -->

                        <!--workerResponseTable card starts  -->
                        <div class="tab-pane fade" id="response" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="mb-0">Worker Response</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">

                                                <!--workerResponseTable  starts  -->
                                                <table id="workerResponseTable"
                                                    class="table table-striped table-bordered custom-table">
                                                    <thead class="table-class">
                                                        <tr>
                                                            <th><b>S.No</b></th>
                                                            <th><b>Complaint</b></th>
                                                            <th><b>Worker</b></th>
                                                            <th><b>Completion Date</b></th>
                                                            <th><b>Picture</b></th>
                                                            <th><b>Faculty Feedback</b></th>
                                                            <th><b>Status</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                        $resserialNo = 1;
                                                        @endphp
                                                        @foreach ($finishedComplaints as $fc)
                                                        <tr>
                                                            <td class="text-center">{{ $resserialNo++ }}</td>
                                                            <td class="text-center">
                                                                <button type="button" value="{{$fc->id}}"
                                                                    class="btn btn-info viewcomplaint"
                                                                    data-value="{{$fc->fac_id}}" data-bs-toggle="modal"
                                                                    data-bs-target="#complaintDetailsModal">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center"><button type="button"
                                                                    class="btn btn-light worker_det" value="{{$fc->id}}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#workerdetailmodal">
                                                                    @if ($fc->worker_name)
                                                                    {{ $fc->worker_name }}
                                                                    @else
                                                                    NA
                                                                    @endif
                                                                </button>
                                                            </td>
                                                            <td class="text-center">{{$fc->date_of_completion}}</td>
                                                            <td class="text-center">
                                                                <button type="button" value="{{$fc->id}}"
                                                                    class="btn btn-info showImage"
                                                                    data-bs-toggle="modal" data-bs-target="#imageModal">
                                                                    <i class="fas fa-image"></i>
                                                                </button>
                                                                <button value="{{$fc->id}}" type="button"
                                                                    class="btn btn-info imgafter" data-bs-toggle="modal"
                                                                    data-bs-target="#afterImageModal">
                                                                    <i class="fas fa-images"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-primary facfeed"
                                                                    value="{{$fc->id}}" data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal">
                                                                    Feedback
                                                                </button>
                                                            </td>
                                                            <td>@if ($fc->task_completion == 'Fully Completed')
                                                                <span
                                                                    class="btn btn-success">{{ $fc->task_completion }}</span>
                                                                @else
                                                                <button class="btn btn-warning partially"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#partially_reason"
                                                                    value="{{ $fc->id }}">
                                                                    {{ $fc->task_completion }}
                                                                </button>
                                                                @endif

                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <!--workerResponseTable ends  -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--workerResponseTable card ends  -->

                        <!--reassignedTable card starts  -->
                        <div class="tab-pane fade" id="reassigned" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="mb-0">Manager Reassigned</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">

                                                <!--reassignedTable  starts  -->
                                                <table id="reassignedTable"
                                                    class="table table-striped table-bordered custom-table">
                                                    <thead class="table-class">
                                                        <tr>
                                                            <th><b>S.No</b></th>
                                                            <th><b>Complaint</b></th>
                                                            <th><b>Worker</b></th>
                                                            <th><b>Date of Reassigned</b></th>
                                                            <th><b>Deadline</b></th>
                                                            <th><b>Picture</b></th>
                                                            <th><b>Faculty Feedback</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                        $reassserialNo = 1;
                                                        @endphp
                                                        @foreach ($reassignedWork as $rw)
                                                        <tr>
                                                            <td class="text-center">{{$reassserialNo++}}</td>
                                                            <td class="text-center">
                                                                <button type="button" value="{{$rw['complaint']->id}}"
                                                                    data-value="{{$rw['complaint']->fac_id}}"
                                                                    class="btn btn-info viewcomplaint"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#complaintDetailsModal">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-light worker_det"
                                                                    value="{{$rw['complaint']->id}}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#workerdetailmodal">
                                                                    {{$rw['worker_name']}}
                                                                </button>
                                                            </td>
                                                            <td class="text-center">{{$rw['complaint']->reassign_date}}
                                                            </td>
                                                            <td class="text-center">
                                                                {{$rw['complaint']->days_to_complete}}
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" value="{{$rw['complaint']->id}}"
                                                                    class="btn btn-info showImage"
                                                                    data-bs-toggle="modal" data-bs-target="#imageModal">
                                                                    <i class="fas fa-image"></i>
                                                                </button>
                                                                <button value="{{$rw['complaint']->id}}" type="button"
                                                                    class="btn btn-info imgafter" data-bs-toggle="modal"
                                                                    data-bs-target="#afterImageModal">
                                                                    <i class="fas fa-images"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                {{$rw['complaint']->feedback}}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <!--reassignedTable  ends  -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--reassignedTable card ends  -->

                        <!--completedWorksTable card starts  -->
                        <div class="tab-pane fade" id="completed-works" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="mb-0">Work's Completed</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">

                                                <!--completedWorksTable  starts  -->
                                                <table id="completedWorksTable"
                                                    class="table table-striped table-bordered custom-table">
                                                    <thead class="table-class">
                                                        <tr>
                                                            <th><b>S.No</b></th>
                                                            <th><b>Complaint</b></th>
                                                            <th><b>Worker</b></th>
                                                            <th><b>Date of Completion</b></th>
                                                            <th><b>Picture</b></th>
                                                            <th><b>Faculty Feedback</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                        $compserialNo = 1;
                                                        @endphp
                                                        @foreach ($completedWork as $cw)
                                                        <tr>
                                                            <td class="text-center">{{$compserialNo++}}</td>
                                                            <td class="text-center">
                                                                <button type="button" value="{{$cw['complaint']->id}}"
                                                                    class="btn btn-info viewcomplaint"
                                                                    data-value="{{$cw['complaint']->fac_id}}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#complaintDetailsModal">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-light worker_det"
                                                                    value="{{$cw['complaint']->id}}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#workerdetailmodal">
                                                                    {{$cw['worker_name']}}
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                {{$cw['complaint']->date_of_completion}}
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" value="{{$cw['complaint']->id}}"
                                                                    class="btn btn-info showImage"
                                                                    data-bs-toggle="modal" data-bs-target="#imageModal">
                                                                    <i class="fas fa-image"></i>
                                                                </button>
                                                                <button value="{{$cw['complaint']->id}}" type="button"
                                                                    class="btn btn-info imgafter" data-bs-toggle="modal"
                                                                    data-bs-target="#afterImageModal">
                                                                    <i class="fas fa-images"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                {{$cw['complaint']->feedback}}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <!--completedWorksTable  starts  -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--completedWorksTable card ends  -->

                        <!--work_completed_table card starts  -->
                        <div class="tab-pane fade" id="work-record" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="mb-0">Work Completed Records</h4>
                                            <form id="monthform">
                                                <label for="selectmonth">Select Month (1-12): </label>
                                                <input type="number" id="selectmonth" name="selectmonth" min="1"
                                                    max="12" value="{{ \Carbon\Carbon::now()->format('m') }}" required>
                                                <button type="submit" class="btn btn-primary">Enter</button>
                                            </form>
                                            <button type="button" class="btn btn-success" id="downloadWorkersRecord">
                                                <i class="fas fa-file-excel"></i>&nbsp;&nbsp;Download Work Record
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">

                                                <!--work_completed_table starts  -->
                                                <table id="work_completed_table"
                                                    class="table table-striped table-bordered custom-table">
                                                    <thead class="table-class text-center">
                                                        <tr>
                                                            <th><b>S.No</b></th>
                                                            <th><b>Work ID</b></th>
                                                            <th><b>Venue Details</b></th>
                                                            <th><b>Completed Details</b></th>
                                                            <th><b>Item No</b></th>
                                                            <th><b>Amount Spent</b></th>
                                                            <th><b>Faculty Feedback</b></th>
                                                            <th><b>Manager Feedback</b></th>
                                                            <th><b>Completed On</b></th>
                                                            <th><b>Average Rating</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="complaintTableBody">
                                                    </tbody>
                                                </table>
                                                <!--work_completed_table ends  -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--work_completed_table card ends  -->

                        <!--workers_table card starts -->
                        <div class="tab-pane fade" id="workers-record" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="mb-0">Worker's Records</h4>
                                            <form id="filterForm" method="POST" action="">
                                                @csrf
                                                <label for="from_date">From Date: </label>
                                                <input type="date" name="from_date" id="from_date" required>
                                                <label for="to_date">To Date: </label>
                                                <input type="date" name="to_date" id="to_date" required>
                                                <button type="submit" class="btn btn-primary">Filter</button>
                                            </form><span style="float:right"></span>
                                            <button type="button" class="btn btn-success"
                                                id="downloadWorkCompletedRecord">
                                                <i class="fas fa-file-excel"></i>&nbsp;&nbsp;Download Workers Record
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">

                                                <!--workers_table starts  -->
                                                <table id="workers_table"
                                                    class="table table-striped table-bordered custom-table">
                                                    <thead class="table-class text-center">
                                                        <tr>
                                                            <th><b>S.No</b></th>
                                                            <th><b>Work ID</b></th>
                                                            <th><b>Worker Name</b></th>
                                                            <th><b>Department</b></th>
                                                            <th><b>Completed Works</b></th>
                                                            <th><b>Faculty Rating</b></th>
                                                            <th><b>Manager Rating</b></th>
                                                            <th><b>Average Rating</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="workerTableBody">
                                                        <!-- Dynamic rows will be inserted here -->
                                                    </tbody>
                                                </table>
                                                <!--workers_table ends  -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--workers_table card ends -->

                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include 'footer.php'; ?>
    </div>
    <script src="script.js"></script>
</body>
</html>
