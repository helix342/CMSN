<?php
require "config.php";
$worker_id = "civil";

//fetching worker details using department in session
$qry = "SELECT * FROM worker_details WHERE worker_id='$worker_id'";
$qry_run = mysqli_query($db,$qry);
$srow  = mysqli_fetch_array($qry_run);
$dept = $srow['worker_dept'];

//table 1 query
$sql4 = "SELECT 
cd.id,
cd.faculty_id,
f.name,
f.dept,
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
faculty f ON cd.faculty_id = f.id
WHERE 
(m.worker_dept = '$dept')
AND 
cd.status = '9'
";
$result4 = mysqli_query($db, $sql4);
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
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <a href="cms_worker.php" class="menu-item ">
                <i class="fas fa-home text-primary"></i>
                <span>Dashboard</span>
            </a>
            <!-- <a href="" class="menu-item">
                <i class="fa-solid fa-user-secret text-white"></i>
                <span>Admin</span>
            </a> -->
            <a href="cms_worknew.php" class="menu-item active">
                <i class="fa-solid fa-users text-info"></i>
                <span>Work</span>
            </a>
            <a href="cms_workall.php" class="menu-item">
                <i class="fa-solid fa-address-book text-success"></i>
                <span><?php echo $worker_id?></span>
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
                    <li class="breadcrumb-item active" aria-current="page">Worker</li>
                </ol>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="container-fluid">
            <div class="container">
                <div class="custom-tabs">
                    <!-- Navigation Tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <!-- Tab 1: Work Assign -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="add-bus-tab" data-bs-toggle="tab"
                                data-bs-target="#workassign" type="button" role="tab">
                                <i class="fas fa-tasks tab-icon"></i> Work Assign
                            </button>
                        </li>

                        
                    </ul>


                    <!-- Tab Content -->
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="workassign" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="mb-0">Complaint Management System</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="pending_table"
                                                    class="table table-striped table-bordered custom-table">
                                                    <thead class="table-class">
                                                        <tr>
                                                            <th><b>S.No</b></th>
                                                            <th><b>Raised</b></th>
                                                            <th><b>Venue</b></th>
                                                            <th><b>Complaint</b></th>
                                                            <th><b>Image</b></th>
                                                            <th><b>Action</b></th>
                                                            <th><b>Status</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                            <?php
                                                    $s = 1;
                                                    while ($row4 = mysqli_fetch_assoc($result4)) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $s ?></td>
                                                                <td><?php echo $row4['date_of_reg'] ?></td>
                                                                <td><?php echo $row4['dept'] ?>/<?php echo $row4['block_venue'] ?></td>
                                                                <td>
                                                                    <button type="button"
                                                                        value="<?php echo $row4['id']; ?>"
                                                                        class="btn btn viewcomplaint"
                                                                        
                                                                        data-toggle="modal"
                                                                        data-target="#complaintDetailsModal">
                                                                        <i class="fas fa-eye"
                                                                            style="font-size: 25px;"></i>
                                                                    </button>
                                                                </td>

                                                                <td>
                                                                    <button type="button"
                                                                        class="btn btn-light btn-sm showImage"
                                                                        value="<?php echo $row4['id']; ?>"
                                                                        data-toggle="modal">
                                                                        <i class="fas fa-image"
                                                                            style="font-size: 25px;"></i>
                                                                    </button>
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button"
                                                                        class="btn btn-success acceptcomplaint"
                                                                        value="<?php echo $row4['id']; ?>"><i
                                                                            class="fas fa-check"></i></button>

                                                                </td>
                                                                <td>
                                                                    <span class="btn btn-success">Approved</span>
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

    <!-- Before Image Modal Starts -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabels" aria-hidden="true">
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

    <!-- View Complaint Modal Starts -->
    <div class="modal fade" id="complaintDetailsModal" tabindex="-1" role="dialog"
        aria-labelledby="complaintDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="complaintDetailsModalLabels">
                        📋 Complaint Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <!-- Modal Body with reduced padding -->
                <div class="modal-body" style="padding: 15px; font-size: 1.1em; color: #333; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

                    <!-- Complaint Info Section with minimized spacing -->
                    <ul class="list-group " style="margin-bottom: 0;">
                                                <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Faculty ID</div>
                                                        <b><span id="faculty_id" style="color: #555;"></span></b>
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Faculty Name</div>
                                                        <b><span id="faculty_name" style="color: #555;"></span></b>
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Mobile Number</div>
                                                        <b><span id="faculty_contact" style="color: #555;"></span></b>
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">E-mail</div>
                                                        <b><span id="faculty_mail" style="color: #555;"></span></b>
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
                                                        <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Problem Description</div>
                                                        <div class="alert alert-light" role="alert" style="border-radius: 6px; background-color: #f1f1f1; padding: 15px; color: #333;">
                                                            <b><span id="problem_description"></span></b>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                </div>

                <!-- Modal Footer with Save Button -->
                <div class="modal-footer" style="border-top: none; justify-content: center; padding: 10px;">
                    <button type="button" class="btn btn-primary btn-lg" data-bs-dismiss="modal" style="border-radius: 25px; padding: 10px 30px; font-size: 1.1em; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- View Complaint Modal Ends -->



    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>


    <script src="assets/script/script.js"></script>
    <script src="assets/script/bootstrap.js"></script>

    <!-- DataTables Initialization -->
    <script>
        $(document).ready(function() {
            $('#pending_table, #approval_table, #work_completed_table,#completed_table, #rejected_table').each(function() {
                $(this).DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    lengthChange: true,
                    pageLength: 10,
                });
            });
        });
    </script>

    <script>
        // Get today's date
        const today = new Date();

        // Calculate last month for From Date
        const lastMonth = new Date();
        lastMonth.setMonth(lastMonth.getMonth() - 1);

        // Format dates to YYYY-MM-DD
        const formatDate = (date) => date.toISOString().split('T')[0];

        // Set default values for From Date and To Date
        document.getElementById('fromDate').value = formatDate(lastMonth);
        document.getElementById('toDate').value = formatDate(today);

        // Optional: Ensure From Date is not after To Date
        document.getElementById('fromDate').addEventListener('change', function() {
            const fromDate = new Date(this.value);
            const toDate = new Date(document.getElementById('toDate').value);
            if (fromDate > toDate) {
                alert("From Date cannot be after To Date");
                this.value = formatDate(lastMonth);
            }
        });

        document.getElementById('toDate').addEventListener('change', function() {
            const fromDate = new Date(document.getElementById('fromDate')
                .value);
            const toDate = new Date(this.value);
            if (toDate < fromDate) {
                alert("To Date cannot be before From Date");
                this.value = formatDate(today);
            }
        });
    </script>
   
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
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();

            $('.viewcomplaint').tooltip({
                placement: 'top',
                title: 'View Complaint'
            });
        });


        $(function() {
            $('[data-toggle="tooltip"]').tooltip();

            $('.showImage').tooltip({
                placement: 'top',
                title: 'Before'
            });
        });

        $(document).ready(function() {
            $("#pending_table").DataTable();
        });

        $(document).ready(function() {
            $("#record_table").DataTable();
        });

        $(function() {
            $('[data-toggle="tooltip"]').tooltip();

            $('.acceptcomplaint').tooltip({
                placement: 'top',
                title: 'Accept'
            });
        });


//Accepting the complaint tick button
        $(document).on("click", ".acceptcomplaint", function(e) {
            e.preventDefault();
            var user_id = $(this).val();
            console.log(user_id);
            $.ajax({
                url: 'cms_backend.php?action=wacceptcomp',
                type: "POST",
                data: {
                    'user_id': user_id
                },
                success: function(response) {
                    if (response.includes("Success")) {
                        alert("done");
                        $('#pending_table').DataTable().destroy();
                        $("#pending_table").load(location.href + " #pending_table > *",
                            function() {
                                $('#pending_table').DataTable();
                            });



                    } else {
                        alert(response);
                    }
                },
                error: function(xhr, status, error) {
                    alert("An error occurred: " + error);
                }
            });
            //for sending mail as accepted
            $.ajax({
                type: "POST",
                url: "cms_mail.php",
                data: {
                    "work_started": true,
                    "id": user_id,
                },
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 200) {
                        console.log(" mail Success!!");
                    } else {
                        console.log("error");
                    }
                }
            })
        });
        //view complaint details in modal

        $(document).on("click", ".viewcomplaint", function(e) {
            e.preventDefault();
            var user_id = $(this).val();
            console.log(user_id);
            $.ajax({
                type: "POST",
                url: 'cms_backend.php?action=whviewcomp',
                data: {
                    user_id: user_id,
                    fac_id: 1,
                },
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    console.log(res);
                    if (res.status == 500) {
                        alert(res.message);
                    } else {
                        $("#id").val(res.data.id);
                        $("#type_of_problem").text(res.data.type_of_problem);
                        $("#problem_description").text(res.data.problem_description);
                        $("#faculty_name").text(res.data.fname);
                        $("#faculty_mail").text(res.data.email);
                        $("#faculty_contact").text(res.data.mobile);
                        $("#block_venue").text(res.data.block_venue);
                        $("#venue_name").text(res.data.venue_name);
                        $("#complaintDetailsModal").modal("show");
                    }
                },
            });
        });
        //viewing before image
        $(document).on("click", ".showImage", function() {
            var problem_id = $(this).val();
            console.log(problem_id);
            $.ajax({
                type: "POST",
                url: 'cms_backend.php?action=get_image',
                data: {
                    problem_id: problem_id,
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        $("#modalImage").attr("src", "uploads/" + response.data.images);
                        $("#imageModal").modal("show");
                    } else {
                        alert(
                            response.message || "An error occurred while retrieving the image."
                        );
                    }
                },
                error: function(xhr, status, error) {
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

//viewing after image
        $(document).on("click", ".imgafter", function() {
            var problem_id = $(this).val();
            $.ajax({
                type: "POST",
                url: 'cms_backend.php?action=get_aimage',
                data: {
                    problem2_id: problem_id,
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        $("#modalImage2").attr("src", response.data.after_photo);
                        $("#afterImageModal").modal("show");
                    } else {
                        alert(response.message || "An error occurred while retrieving the image.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", status, error);
                }
            });
        });


       //download record as excel file
        document.getElementById('download').addEventListener('click', function() {
            var wb = XLSX.utils.book_new();
            var ws = XLSX.utils.table_to_sheet(document.getElementById('record_table'));
            XLSX.utils.book_append_sheet(wb, ws, "Complaints Data");

            // Create and trigger the download
            XLSX.writeFile(wb, 'complaints_data.xlsx');
        });
        </script>







</body>

</html>