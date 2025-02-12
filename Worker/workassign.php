<?php
require "config.php";
include ("session.php");
$worker_id = $s;
if(!($worker_id)){
    header("Location:index.php");

}
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
        background: transparent;
        /* Default state - colorless */
        color: black;
        /* Default text color */
        border: none;
        /* Remove border */
        margin: 2px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link.active {
        background: linear-gradient(135deg, rgb(78, 101, 255), rgb(146, 239, 253));
        color: white;
        /* Text color for active tab */
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
                        <a class="nav-link active" data-bs-toggle="tab" href="#workassign" role="tab">Work
                            Assign</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#workrecord" role="tab">Work
                            Record</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- In Progress -->
                    <div class="tab-pane fade show active p-20" id="workassign" role="tabpanel">
                        <h5 class="card-title">Work Assign</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="workerassign">
                                <thead class="gradient-header">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Raised Date</th>
                                        <th>Department/Venue</th>
                                        <th>Complaint</th>
                                        <th>Picture</th>
                                        <th>Action</th>
                                        <th>Status</th>
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
                                            <button type="button" value="<?php echo $row4['id']; ?>"
                                                class="btn btn viewcomplaint" data-toggle="modal"
                                                data-target="#complaintDetailsModal">
                                                <i class="fas fa-eye" style="font-size: 25px;"></i>
                                            </button>
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-light btn-sm showImage"
                                                value="<?php echo $row4['id']; ?>" data-toggle="modal">
                                                <i class="fas fa-image" style="font-size: 25px;"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-success acceptcomplaint"
                                                value="<?php echo $row4['id']; ?>"><i class="fas fa-check"></i></button>

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

                    <!-- Waiting for Approval -->
                    <div class="tab-pane fade p-20" id="workrecord" role="tabpanel">
                        <h5 class="card-title">Work Completed Records</h5>
                        <form method="POST" action="">
                            <label for="selectmonth">Select Month (1-12): </label>
                            <input type="number" name="selectmonth" min="1" max="12"
                                value="" required>
                            <button type="submit" class="btn btn-primary">Enter</button>
                        </form><span style="float:right">
                            <button id="download" class="btn btn-success">Download
                                as Excel</button></span><br><br>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="workerrecord">
                                <thead class="gradient-header">
                                    <tr>
                                        <th>
                                            S.No
                                        </th>
                                        <th>
                                            Work ID
                                        </th>
                                        <th>
                                            Venue Details
                                        </th>
                                        <th>
                                            Completed Details
                                        </th>
                                        <th>
                                            Completed On
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
                                            <button type="button" class="btn I" style="margin-left:-12px;"
                                                data-toggle="modal" data-target="#Modal4"
                                                data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
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
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
        // DataTables
        $(document).ready(function() {
            $('#workerassign').DataTable();
            $('#workerrecord').DataTable();
        });
    </script>
</body>

</html>