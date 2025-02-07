<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MKCE TEMPLATE</title>
    <link rel="icon" type="image/png" sizes="32x32" href="image/icons/mkce_s.png">
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Rubik:wght@300;400;500;700&family=Outfit:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
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
            <a href="/placement-dashboard" class="menu-item">
                <i class="fas fa-tachometer-alt text-primary"></i>
                <span>Dashboard</span>
            </a>

            <a href="/companies" class="menu-item">
                <i class="fas fa-building text-warning"></i>
                <span>Companies</span>
            </a>

            <div class="menu-item has-submenu">
                <i class="fas fa-chart-bar text-success"></i>
                <span>Analytics</span>
            </div>
            <div class="submenu">
                <a href="/analytics/reports" class="menu-item">
                    <i class="fas fa-file-alt text-warning"></i>
                    <span>Reports</span>
                </a>
                <a href="/analytics/statistics" class="menu-item">
                    <i class="fas fa-chart-line text-info"></i>
                    <span>Statistics</span>
                </a>
            </div>

            <div class="menu-item has-submenu">
                <i class="fas fa-users text-danger"></i>
                <span>Students</span>
            </div>
            <div class="submenu">
                <a href="/students/register" class="menu-item">
                    <i class="fas fa-user-plus text-warning"></i>
                    <span>Register Student</span>
                </a>
                <a href="/students/manage" class="menu-item">
                    <i class="fas fa-user-edit text-info"></i>
                    <span>Manage Students</span>
                </a>
                <a href="/students/interview-schedule" class="menu-item">
                    <i class="fas fa-calendar-check text-info"></i>
                    <span>Interview Schedule</span>
                </a>
            </div>

            <div class="menu-item has-submenu">
                <i class="fas fa-cogs text-secondary"></i>
                <span>Settings</span>
            </div>
            <div class="submenu">
                <a href="/settings/company-details" class="menu-item">
                    <i class="fas fa-building text-warning"></i>
                    <span>Company Details</span>
                </a>
                <a href="/settings/notifications" class="menu-item">
                    <i class="fas fa-bell text-info"></i>
                    <span>Notifications</span>
                </a>
            </div>

            <a href="/logout" class="menu-item">
            <i class="fas fa-file-contract"></i>
                <span>Terms & Conditions</span>
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
                <span>John Doe</span>
            </div>
        </div>

        <!-- Breadcrumb -->
        <div class="breadcrumb-area">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="container-fluid">
            <!-- Sample Table -->

            <div class="custom-table">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#001</td>
                            <td>John Doe</td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#002</td>
                            <td>Jane Smith</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Footer -->
        <footer class="footer">
            <div class="footer-copyright" style="text-align: center;">
                <p>Copyright © 2024 Designed by <span style="background: linear-gradient(to right, #cb2d3e, #ef473a);"
                        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip:
                        text;">Technology Innovation Hub - MKCE. </span>All rights reserved.</p>
            </div>
            <div class="footer-links">

                <a href="#"><i class="fab fa-linkedin"></i></a>
            </div>
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>
