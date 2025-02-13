<?php
require 'config.php';
include("session.php");
$eo_id = $fac_id;
$role = $frole;

$sql = "
SELECT cd.*, f.name,f.dept
FROM complaints_detail cd
JOIN faculty f ON cd.faculty_id = f.id
WHERE cd.status = '4'
ORDER BY 
    CASE WHEN f.role = 'HOD' THEN 0 ELSE 1 END
";
$sql1 = "
SELECT cd.*, f.name, f.dept
FROM complaints_detail cd
JOIN faculty f ON cd.faculty_id = f.id
WHERE cd.status IN (6,8,9, 7, 10, 11, 15,14, 22)
";
$sql2 = "
SELECT cd.*, f.name, f.dept
FROM complaints_detail cd
JOIN faculty f ON cd.faculty_id = f.id
WHERE cd.status = '16'
";
$sql3 = "
SELECT cd.*, f.name,f.dept
FROM complaints_detail cd
JOIN faculty f ON cd.faculty_id = f.id
WHERE cd.status IN (19, 20)
";
$result = mysqli_query($db, $sql);
$pending = mysqli_num_rows($result);
$result1 = mysqli_query($db, $sql1);
$approved = mysqli_num_rows($result1);
$result2 = mysqli_query($db, $sql2);
$completed = mysqli_num_rows($result2);
$result3 = mysqli_query($db, $sql3);
$rejected = mysqli_num_rows($result3);
$sql11 = "SELECT * FROM complaints_detail WHERE status IN (11,18,14) AND faculty_id = '$eo_id'";
$result11 = mysqli_query($db, $sql11);
$row_count11 = mysqli_num_rows($result11);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Complaints Management System</title>
    <link rel="icon" type="image/png" sizes="32x32" href="image/icons/mkce_s.png">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/tabs.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/datatable.css">
    <link rel="stylesheet" href="assets/css/font.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/alertify.min.css" />
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
            <!-- Dashboard -->
            <a href="{{route('admin')}}" class="menu-item">
                <i class="fas fa-tachometer-alt text-primary"></i>
                <span>Dashboard</span>
            </a>

            <!-- Faculty -->
            <a href="{{route('faculty')}}" class="menu-item">
                <i class="fas fa-chalkboard-teacher text-info"></i>
                <span>Infra</span>
            </a>

            <!-- HOD -->
            <a href="{{route('hod')}}" class="menu-item">
                <i class="fas fa-user-tie text-warning"></i>
                <span>HOD</span>
            </a>

            <!-- Estate Office -->
            <a href="{{route('eo')}}" class="menu-item active">
                <i class="fas fa-building text-success"></i>
                <span>Estate Office</span>
            </a>
            <a href="{{route('manager')}}" class="menu-item">
                <i class="fa-regular fa-handshake text-danger"></i>
                <span>Manager</span>
            </a>
            <a href="{{route('login')}}" class="menu-item">
                <i class="fas fa-tools text-secondary"></i>
                <span>Worker</span>
            </a>
            <!-- Principal -->
            <a href="{{route('principal')}}" class="menu-item">
                <i class="fas fa-user-graduate text-info"></i>
                <span>Principal</span>
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
                        <img src="" alt="User">
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
                <span>TIH</span>
            </div>
        </div>

        <!-- Breadcrumb -->
        <div class="breadcrumb-area">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">EO</li>
                </ol>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="container-fluid">
            <div class="container">
                <div class="custom-tabs">
                    <!-- Navigation Tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <!-- Tab 1: Dashboard -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="delete-bus-tab" data-bs-toggle="tab"
                                data-bs-target="#dashboard" type="button" role="tab">
                                <i class="fas fa-tachometer-alt tab-icon"></i>Dashboard
                            </button>
                        </li>

                        <!-- Tab 2: Pending -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="fleet-management-bus-tab" data-bs-toggle="tab"
                                data-bs-target="#pending" type="button" role="tab">
                                <i class="fas fa-hourglass-half tab-icon"></i>Pending (<?php echo $pending; ?>)
                            </button>
                        </li>

                        <!-- Tab 3: Approved -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="edit-bus-tab" data-bs-toggle="tab" data-bs-target="#approved"
                                type="button" role="tab">
                                <i class="fas fa-check-circle tab-icon"></i>Approved (<?php echo $approved; ?>)
                            </button>
                        </li>

                        <!-- Tab 4: Completed -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="route-bus-tab" data-bs-toggle="tab" data-bs-target="#completed"
                                type="button" role="tab">
                                <i class="fas fa-tasks tab-icon"></i>Completed (<?php echo $completed; ?>)
                            </button>
                        </li>

                        <!-- Tab 5: Rejected -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="settings-bus-tab" data-bs-toggle="tab"
                                data-bs-target="#rejected" type="button" role="tab">
                                <i class="fas fa-times-circle tab-icon"></i>Rejected (<?php echo $rejected; ?>)
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="route-bus-tab" data-bs-toggle="tab" data-bs-target="#rejected"
                                type="button" role="tab">
                                <i class="fas fa-folder-open"></i>&nbsp;&nbsp;Record
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="add-bus-tab" data-bs-toggle="tab" data-bs-target="#rejected"
                                type="button" role="tab">
                                <i class="fas fa-tools"></i>&nbsp;&nbsp;Rejected (<?php echo $rejected; ?>)
                            </button>
                        </li>

                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
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
                                                                        <?php echo $pending;?>
                                                                    </h1>
                                                                    <small class="font-light">Pending
                                                                    </small>
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
                                                                        <?php echo $approved;?>
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
                                                                <div class="stats-box text-center p-3"
                                                                    style="background-color:rgb(70, 160, 70);">
                                                                    <i class="fas fa-check-circle"></i>
                                                                    <h1 class="font-light text-white">
                                                                        <?php echo $completed;?></h1>
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
                                                                        <?php echo $rejected;?>
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
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="pending" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="mb-0">Complaint Management System</h4>

                                            <button type="button" class="btn btn-danger float-right fac"
                                                data-bs-toggle="modal" data-bs-target="#raisemodal"><i
                                                    class="fas fa-bullhorn"></i>&nbsp;&nbsp;Raise
                                                Compliant</button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="pending_table"
                                                    class="table table-striped table-bordered custom-table">
                                                    <thead class="table-class">
                                                        <tr>
                                                            <th><b>S.No</b></th>
                                                            <th><b>Date</b></th>
                                                            <th><b>Faculty Name</b></th>
                                                            <th><b>Problem Description</b></th>
                                                            <th><b>Image</b></th>
                                                            <th><b>Action</b></th>
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
                                                            <td class="text-center">
                                                                <?php echo $row['date_of_reg']; ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php echo $row['dept'] ?> /
                                                                <?php echo $row['block_venue'] ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btndesc"
                                                                    id="seeproblem" data-bs-toggle="modal"
                                                                    data-bs-target="#complaintDetailsModal"
                                                                    data-bs-value="<?php echo $row['fac_id']; ?>"
                                                                    value="<?php echo $row['id']; ?>">
                                                                    <i class="fas fa-solid fa-eye"
                                                                        style="font-size: 20px;"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-primary showImage"
                                                                    value="<?php echo $row['id']; ?>"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-task-id='<?php echo htmlspecialchars($row['id']); ?>'>
                                                                    <i class="fas fa-camera"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" value="<?php echo $row['id']; ?>"
                                                                    id="detail_id" class="btn btn-success btnapprove">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                                <button type="button" value="<?php echo $row['id']; ?>"
                                                                    class="btn btn-danger btnreject"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#rejectmodal">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
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
                        <div class="tab-pane fade" id="approved" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="mb-0">Complaint Management System</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="approval_table"
                                                    class="table table-striped table-bordered custom-table">
                                                    <thead class="table-class">
                                                        <tr>
                                                            <th><b>S.No</b></th>
                                                            <th><b>Date</b></th>
                                                            <th><b>Faculty Name</b></th>
                                                            <th><b>Problem Description</b></th>
                                                            <th><b>Image</b></th>
                                                            <th><b>Status</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $s = 1; @endphp
                                                        @foreach($data as $d)
                                                        @if(in_array($d->status, [ 6, 7, 10, 11, 13, 14, 15, 17,
                                                        18,22]))

                                                        <tr>
                                                            <td class="text-center">
                                                                {{$s++}}
                                                            </td>
                                                            <td>
                                                                <center>
                                                                    {{ \Carbon\Carbon::parse($d->date_of_reg)->format('Y-m-d') }}
                                                                </center>
                                                            </td>
                                                            <td>
                                                                <center>
                                                                    <button type="button"
                                                                        class="btn btn-link faculty btndisplay"
                                                                        id="facultyinfo" data-bs-toggle="modal"
                                                                        value="{{ $d->faculty_id }}"
                                                                        data-bs-target="#facultymodal"
                                                                        style="text-decoration:none;">
                                                                        {{$d->faculty_name}}
                                                                    </button>
                                                                </center>
                                                            </td>
                                                            <td>
                                                                <center>
                                                                    <button type="button" class="btn btndesc"
                                                                        id="seeproblem" data-bs-toggle="modal"
                                                                        data-bs-target="#complaintDetailsModal"
                                                                        value="{{$d->complaint_id}}">
                                                                        <i class="fas fa-solid fa-eye"
                                                                            style="font-size: 20px;"></i>
                                                                    </button>
                                                                </center>
                                                            </td>
                                                            <td>
                                                                <center>
                                                                    <button type="button"
                                                                        class="btn btn-primary showImage"
                                                                        value="{{ $d->complaint_id }}"
                                                                        data-bs-toggle="modal">
                                                                        <i class="fas fa-camera"></i>
                                                                    </button>
                                                                </center>
                                                            </td>
                                                            <td>
                                                                <center>
                                                                    <button type="button" class="btn btn-secondary">
                                                                        @if ($d->status == 2)
                                                                        Approved by infra
                                                                        @elseif ($d->status == 3)
                                                                        Rejected by infra
                                                                        @elseif ($d->status == 4)
                                                                        Forwarded to EO
                                                                        @elseif ($d->status == 6)
                                                                        Sent to principal for approval
                                                                        @elseif ($d->status == 7)
                                                                        Assigned to worker
                                                                        @elseif ($d->status == 10)
                                                                        Work in progress
                                                                        @elseif ($d->status == 11)
                                                                        Waiting for approval
                                                                        @elseif ($d->status == 13)
                                                                        Sent to infra for completion
                                                                        @elseif ($d->status == 14)
                                                                        Waiting to be Reassigned
                                                                        @elseif ($d->status == 15)
                                                                        Work is Reassigned
                                                                        @elseif ($d->status == 17)
                                                                        Work in Progress
                                                                        @elseif ($d->status == 18)
                                                                        Waiting for Approval
                                                                        @elseif ($d->status == 22)
                                                                        Forwarded to Manager
                                                                        @else
                                                                        Unknown status
                                                                        @endif
                                                                    </button>
                                                                </center>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @endforeach
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
                                        <div class="card-header">
                                            <h4 class="mb-0">Complaint Management System</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="completed_table"
                                                    class="table table-striped table-bordered custom-table">
                                                    <thead class="table-class">
                                                        <tr>
                                                            <th class="text-center"><b>S.No</b></th>
                                                            <th class="text-center"><b>Date</b></th>
                                                            <th class="text-center"><b>Staff Name</b></th>
                                                            <th class="text-center"><b>Problem Description</b></th>
                                                            <th class="text-center"><b>Before Image</b></th>
                                                            <th class="text-center"><b>After Image</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $s = 1; @endphp
                                                        @foreach($data as $d)
                                                        @foreach($man as $m)
                                                        @if($d->complaint_id == $m->problem_id)
                                                        <!-- Check condition between complaints_detail and manager -->
                                                        @foreach($value as $v)
                                                        @if($m->task_id == $v->task_id)
                                                        <!-- Check condition between manager and workertaskdet -->
                                                        @if($d->status == 16)
                                                        <!-- Check the status -->
                                                        <tr>
                                                            <td class="text-center">{{ $s++ }}</td>
                                                            <td class="text-center">
                                                                {{ \Carbon\Carbon::parse($d->date_of_reg)->format('Y-m-d') }}
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button"
                                                                    class="btn btn-link faculty btndisplay"
                                                                    id="facultyinfo" data-bs-toggle="modal"
                                                                    data-bs-target="#facultymodal"
                                                                    value="{{ $d->faculty_id }}"
                                                                    style="text-decoration:none;">
                                                                    {{ $d->faculty_name }}
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btndesc"
                                                                    id="seeproblem" data-bs-toggle="modal"
                                                                    data-bs-target="#complaintDetailsModal"
                                                                    value="{{ $d->complaint_id }}">
                                                                    <i class="fas fa-solid fa-eye"
                                                                        style="font-size: 20px;"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-primary showImage"
                                                                    value="{{ $d->complaint_id }}"
                                                                    data-bs-toggle="modal">
                                                                    <i class="fas fa-camera"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button"
                                                                    class="btn btn-primary viewafterimgcomp"
                                                                    value="{{ $m->task_id }}" data-bs-toggle="modal"
                                                                    data-bs-target="#aftercomp">
                                                                    <i class="fas fa-camera"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @endif
                                                        @endforeach
                                                        @endif
                                                        @endforeach
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="rejected" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="mb-0">Complaint Management System</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="rejected_table"
                                                    class="table table-striped table-bordered custom-table">
                                                    <thead class="table-class">
                                                        <tr>
                                                            <th><b>S.No</b></th>
                                                            <th><b>Date</b></th>
                                                            <th><b>Staff Name</b></th>
                                                            <th><b>Problem Description</b></th>
                                                            <th><b>Image</b></th>
                                                            <th><b>Reason</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $s = 1; @endphp
                                                        @foreach($data as $d)
                                                        @if(in_array($d->status, [19, 20, 23]))
                                                        <tr>
                                                            <td class="text-center">
                                                                {{$s++}}
                                                            </td>
                                                            <td>
                                                                <center>
                                                                    {{ \Carbon\Carbon::parse($d->date_of_reg)->format('Y-m-d') }}
                                                                </center>
                                                            </td>
                                                            <td>
                                                                <center>
                                                                    <button type="button"
                                                                        class="btn btn-link faculty btndisplay"
                                                                        id="facultyinfo" data-bs-toggle="modal"
                                                                        value="{{ $d->faculty_id }}"
                                                                        data-bs-target="#facultymodal"
                                                                        style="text-decoration:none;">
                                                                        {{$d->faculty_name}}
                                                                    </button>
                                                                </center>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btndesc"
                                                                    id="seeproblem" data-bs-toggle="modal"
                                                                    data-bs-target="#complaintDetailsModal"
                                                                    value="{{$d->complaint_id}}">
                                                                    <i class="fas fa-solid fa-eye"
                                                                        style="font-size: 20px;"></i>
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <center>
                                                                    <button type="button"
                                                                        class="btn btn-primary showImage"
                                                                        value="{{ $d->complaint_id }}"
                                                                        data-bs-toggle="modal">
                                                                        <i class="fas fa-camera"></i>
                                                                    </button>
                                                                </center>
                                                            </td>
                                                            <td>
                                                                <center>
                                                                    <button type="button" value="{{$d->complaint_id}}"
                                                                        class="btn btn-danger btnrejfeed"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#problemrejected"
                                                                        id="rejectedfeedback">
                                                                        <i class="fas fa-solid fa-comment"
                                                                            style="font-size: 20px; width:40px;"></i>
                                                                    </button>
                                                                </center>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @endforeach
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


    <div id="aftercomp" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header"
                    style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                    <h5 class="modal-title">View Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="afterimgcomp" src="" alt="Image Preview" style="max-width: 100%; display: none;" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="rejectmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"
                    style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Reason for rejection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form id="rejectdetails">
                    <div class="modal-body" style="font-size:larger;">
                        <textarea class="form-control" placeholder="Enter Reason" name="rejfeedfac"
                            style="width:460px;height: 180px; resize:none" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="raisemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"
                    style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                    <h5 class="modal-title" id="exampleModalLabel">Raise Complaint</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div>
                    <form id="addnewuser" enctype="multipart/form-data" onsubmit="handleSubmit(event)">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="block" class="form-label">Block <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="block_venue" placeholder="Eg: RK-206"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="venue" class="form-label">Venue <span style="color: red;">*</span></label>
                                <select id="dropdown" class="form-select" name="venue_name" onchange="checkIfOthers()"
                                    required>
                                    <option value="">Select</option>
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
                                <input class="form-control" type="text" id="otherValue" name="otherValue">
                            </div>
                            <div class="mb-3">
                                <label for="type_of_problem" class="form-label">Type of Problem <span
                                        style="color: red;">*</span></label>
                                <select class="form-select" name="type_of_problem" required>
                                    <option value="">Select</option>
                                    <option value="electrical">ELECTRICAL</option>
                                    <option value="civil">CIVIL</option>
                                    <option value="itkm">IT INFRA</option>
                                    <option value="transport">TRANSPORT</option>
                                    <option value="house">HOUSE KEEPING</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Problem Description <span
                                        style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="problem_description"
                                    placeholder="Enter Description" required>
                            </div>
                            <div class="mb-3">
                                <label for="images" class="form-label">Image <span style="color: red;">*</span></label>
                                <input type="file" class="form-control" name="images" id="images"
                                    onchange="validateSize(this)" required>
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


    <!-- Before Image Modal Starts -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Complaint Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" alt="Image" class="img-fluid">
                    <!-- src will be set dynamically -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Before Image Model Ends -->


    <div class="modal fade" id="facultymodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"
                    style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                    <h5 class="modal-title" id="exampleModalLabel">Faculty Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body"
                    style="padding: 15px; font-size: 1.1em; color: #333; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                    <ol class="list-group list-group-numbered" style="margin-bottom: 0;">
                        <li class="list-group-item d-flex justify-content-between align-items-start"
                            style="padding: 10px; background-color: #fff;">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Faculty
                                    Name</div>
                                <b><span id="faculty_name" style="color: #555;"></span></b>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start"
                            style="padding: 10px; background-color: #fff;">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">
                                    Department</div>
                                <b><span id="department" style="color: #555;"></span></b>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start"
                            style="padding: 10px; background-color: #fff;">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Contact
                                </div>
                                <b><span id="faculty_contact" style="color: #555;"></span></b>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start"
                            style="padding: 10px; background-color: #fff;">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Faculty
                                    mail</div>
                                <b><span id="faculty_mail" style="color: #555;"></span></b>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start"
                            style="padding: 10px; background-color: #fff;">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Role
                                </div>
                                <b><span id="role" style="color: #555;"></span></b>
                            </div>
                        </li>
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Problem Description Modal -->
    <div class="modal fade" id="complaintDetailsModal" tabindex="-1" aria-labelledby="complaintDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="complaintDetailsModalLabel">📋 Complaint Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Complaint ID</label>
                            <div class="text-muted"><b id="id"></b></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Type of Problem</label>
                            <div class="text-muted"><b id="type_of_problem"></b></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Block Venue</label>
                            <div class="text-muted"><b id="block_venue"></b></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Venue Name</label>
                            <div class="text-muted"><b id="venue_name"></b></div>
                        </div>
                        <div class="col-md-12">
                            <label class="fw-bold">Problem Description</label>
                            <div class="alert alert-light" role="alert">
                                <span id="problem_description"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Rejected reason Model -->
    <div class="modal fade" id="problemrejected" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Reason for Rejection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addnewdetails">
                    <div class="modal-body">
                        <textarea id="pdrej2" class="form-control" rows="6" disabled></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/script/script.js"></script>
    <script src="assets/script/bootstrap.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables Initialization -->
    <script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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

    $(document).ready(function() {
        $('#pending_table, #approval_table, #completed_table, #rejected_table').each(function() {
            $(this).DataTable({
                paging: true,
                searching: true,
                ordering: true,
                lengthChange: true,
                pageLength: 10,
            });
        });
    });

    $(document).on('click', '.btndisplay', function(e) {
        e.preventDefault();
        var user_id = $(this).val(); // Get the complaint ID
        $.ajax({
            type: "GET",
            url: `eo/pend/pends/${user_id}`, // Fetch the specific faculty linked to the complaint
            success: function(response) {
                if (response.status === 404) {
                    alert(response.message); // Handle faculty not found
                } else if (response.status === 200) {
                    console.log(response);
                    $("#id").val(response.data.faculty_id);
                    $("#faculty_name").text(response.data.faculty_name);
                    $("#department").text(response.data.department);
                    $("#faculty_contact").text(response.data.faculty_contact);
                    $("#faculty_mail").text(response.data.faculty_mail);
                    $("#role").text(response.data.role);
                    $('#facultymodal').modal('show');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                alert('An error occurred. Please try again.');
            }
        });
    });

    $(document).on('click', '#seeproblem', function(e) {
        e.preventDefault();
        var user_id = $(this).val();
        $.ajax({
            type: "get",
            url: `eo/user/display/${user_id}`,
            success: function(response) {
                console.log(response);
                if (response.status === 404) {
                    alert(response.message);
                } else if (response.status === 200) {
                    $("#id").text(response.data.id);
                    $("#type_of_problem").text(response.data.type_of_problem);
                    $("#problem_description").text(response.data.problem_description);
                    $("#block_venue").text(response.data.block_venue);
                    $("#venue_name").text(response.data.venue_name);
                    $('#complaintDetailsModal').modal('show');
                }
            },
            error: function() {
                alert("An error occurred while fetching the details.");
            }
        });
    });

    $(document).on('click', '.showImage', function() {
        var user_id = $(this).val();
        $.ajax({
            type: "GET",
            url: `eo/user/eobefore/${user_id}`,
            success: function(response) {
                if (response.status == 200) {
                    $('#modalImage').attr('src', 'before_image/' + response.data.images);
                    $('#imageModal').modal('show');
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

    $(document).on('click', '.btnapprove', function(e) {
        e.preventDefault();
        var user_id = $(this).val();
        console.log(user_id);
        if (confirm('Are you sure you want to approve?')) {
            $.ajax({
                type: "POST",
                url: `eo/user/approve/${user_id}`, // Fixed URL format
                success: function(response) {
                    if (response.status == 500) {
                        alert(response.message);
                    } else {
                        Swal.fire({
                            title: "APPROVED",
                            text: "Approved successfully!",
                            icon: "success", // Fixed typo here
                            confirmButtonText: "OK",
                        });
                        // Reload the current tab
                        $('#pending_table').DataTable().destroy();
                        $("#pending_table").load(location.href + " #pending_table > *", function() {
                            $('#pending_table').DataTable();
                        });
                        // Reload the work-in-progress tab
                        $('#approval_table').DataTable().destroy();
                        $("#approval_table").load(location.href + " #approval_table > *",
                            function() {
                                $('#approval_table').DataTable();
                            });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert('An error occurred. Please try again.');
                }
            });
        }
    });



    $(document).on('click', '.btnreject', function() {
        var user_id = $(this).val(); // Get the value from the button
        $('#rejectmodal').data('id', user_id); // Set the user_id in the modal
    });
    //Reject Button with Feedback
    $(document).on('submit', '#rejectdetails', function(e) {
        e.preventDefault();
        var user_id = $('#rejectmodal').data('id'); // Retrieve user_id from modal's data
        console.log(user_id);
        var formData = new FormData(this);
        console.log(formData);
        $.ajax({
            type: "POST",
            url: `eo/user/reject/${user_id}`,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                if (response.status == 200) {
                    Swal.fire({
                        title: "REJECTED",
                        text: "Rejected successfully!",
                        icon: "warning",
                        confirmButtonText: "OK",
                    });
                    $('#rejectmodal').modal('hide'); // Removes the modal backdrop
                    $('body').removeClass('modal-open');
                    $('#rejectdetails')[0].reset();
                    $('#pending_table').load(location.href + " #pending_table");
                    $('#rejected_table').load(location.href + " #rejected_table");
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

    $(document).on('click', '.viewafterimgcomp', function() {
        var user_id = $(this).val();
        console.log(user_id);
        // Fetch the image from the server
        $.ajax({
            type: "GET",
            url: `eo/user/eoafter/${user_id}`,
            success: function(response) {
                if (response.status == 200) {
                    $('#afterimgcomp').attr('src', 'imgafter/' + response.data.after_photo);
                    $('#aftercomp').modal('show');
                } else {
                    $('afterimgcomp').hide();
                    alert(response.message);
                }
                $('#aftercomp').modal('show');
            },
            error: function(xhr, status, error) {
                alert('An error occurred while retrieving the image.');
            }
        });
    });

    $(document).on('click', '#rejectedfeedback', function(e) {
        e.preventDefault();
        var user_idrej = $(this).val();
        console.log(user_idrej)
        $.ajax({
            type: "GET",
            url: `eo/user/rejfeedback/${user_idrej}`,
            success: function(response) {
                console.log(response)
                if (response.status == 500) {
                    alert(response.message);
                } else {
                    $('#pdrej2').text(response.data.feedback);
                    $('#problemrejected').modal('show');
                }
            }
        });
    });

    $(document).on('submit', '#addnewuser', function(e) {
        e.preventDefault(); // Prevent form from submitting normally
        var formData = new FormData(this);
        var currentDate = new Date().toISOString().split('T')[0]; // Get current date (YYYY-MM-DD)
        formData.append('date_of_reg', currentDate);
        $.ajax({
            type: "POST",
            url: '/eadd-complaint', // Laravel route
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status === 200) {
                    $('#raisemodal').modal('hide');
                    $('#addnewuser')[0].reset(); // Reset the form
                    $('#pending_table').DataTable().destroy();
                    $("#pending_table").load(location.href + " #pending_table > *", function() {
                        $('#pending_table').DataTable();
                    });
                    // Reload the work-in-progress tab
                    $('#approval_table').DataTable().destroy();
                    $("#approval_table").load(location.href + " #approval_table > *", function() {
                        $('#approval_table').DataTable();
                    });
                } else {
                    console.error("Error:", response.message);
                    alert("Something went wrong! Try again.");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                alert("Failed to process response. Please try again.");
            }
        });
    });
    </script>

</body>

</html>