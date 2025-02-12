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
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>MIC</title>
    <link rel="icon" type="image/png" sizes="32x32" href="../image/icons/mkce_s.png">
    <link rel="stylesheet" href="../css/stylescms.css">
    <link rel="stylesheet" href="styles.css">
    <link href="../css/dboardstyles.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-5/bootstrap-5.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Rubik:wght@300;400;500;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">


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
        }

        body {
            background: #f0f2f5;
        }

        .custom-tabs {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
        }

        .nav-tabs {
            border: none;
            gap: 10px;
            padding: 6px;
            background: #f8f9fd;
            border-radius: 12px;
        }

        .nav-link {
            border: none !important;
            border-radius: 10px !important;
            padding: 10px 20px !important;
            font-weight: 600 !important;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
            z-index: 1;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: inherit;
            z-index: -1;
            transform: translateY(100%);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-link:hover::before {
            transform: translateY(0);
        }

        .nav-link.active {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Add Bus Tab Styling */
        #add-bus-tab {
            background: linear-gradient(135deg, #FF6B6B, #FFE66D);
            color: #fff;
        }

        #add-bus-tab:not(.active) {
            background: #fff;
            color: #FF6B6B;
        }

        #add-bus-tab:hover:not(.active) {
            background: linear-gradient(135deg, #FF6B6B, #FFE66D);
            color: #fff;
        }

        /* Edit Bus Tab Styling */
        #edit-bus-tab {
            background: linear-gradient(135deg, #4E65FF, #92EFFD);
            color: #fff;
        }

        #edit-bus-tab:not(.active) {
            background: #fff;
            color: #4E65FF;
        }

        #edit-bus-tab:hover:not(.active) {
            background: linear-gradient(135deg, #4E65FF, #92EFFD);
            color: #fff;
        }

        .tab-icon {
            margin-right: 8px;
            font-size: 1.1em;
            transition: transform 0.3s ease;
        }

        .nav-link:hover .tab-icon {
            transform: rotate(15deg) scale(1.1);
        }

        .nav-link.active .tab-icon {
            animation: bounce 0.5s ease infinite alternate;
        }

        @keyframes bounce {
            from {
                transform: translateY(0);
            }

            to {
                transform: translateY(-2px);
            }
        }

        .tab-content {
            padding: 20px;
            margin-top: 15px;
            background: #fff;
            border-radius: 12px;
            min-height: 200px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .tab-pane {
            opacity: 0;
            transform: translateY(15px);
            transition: all 0.4s ease-out;
        }

        .tab-pane.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Glowing effect on active tab */
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 50%;
            transform: translateX(-50%);
            width: 40%;
            height: 3px;
            background: inherit;
            border-radius: 6px;
            filter: blur(2px);
            animation: glow 1.5s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                opacity: 0.6;
                width: 40%;
            }

            to {
                opacity: 1;
                width: 55%;
            }
        }

        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #f97316;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --bg-primary: #f8fafc;
            --bg-secondary: #ffffff;
            --border-color: #e2e8f0;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            background: var(--bg-secondary);
            border-radius: 24px;
            padding: 0.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 300px;
            background: linear-gradient(45deg, var(--primary) 0%, var(--secondary) 100%);
            opacity: 0.1;
            border-radius: 50%;
            transform: translate(150px, -150px);
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;
            /* Fallback for browsers that don't support background-clip */
            margin-bottom: 1.5rem;
            position: relative;
        }

        .date-input-container {
            display: flex;
            gap: 1rem;
            align-items: center;
            position: relative;
        }

        .date-input {
            padding: 1rem 1.5rem;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 1rem;
            background: var(--bg-secondary);
            color: var(--text-primary);
            transition: all 0.3s ease;
            flex: 1;
            max-width: 200px;
        }

        .date-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn1 {
            background: var(--primary);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }

        .btn1:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 8px -1px rgba(79, 70, 229, 0.3);
        }

        .department-card {
            background: var(--bg-secondary);
            border-radius: 24px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .department-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .department-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 0.5rem;
            color: white;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .department-header::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(50px, -100px);
        }

        .department-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(8px);
        }

        .department-icon i {
            font-size: 1.75rem;
            color: white;
        }

        .department-name {
            font-size: 1.75rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .batch-container {
            padding: 2rem;
        }

        .batch-row {
            display: grid;
            grid-template-columns: 1.5fr repeat(3, 1fr);
            gap: 0.5rem;
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            align-items: center;
            transition: all 0.3s ease;
        }

        .batch-row:hover {
            background: var(--bg-primary);
        }

        .batch-row:last-child {
            border-bottom: none;
        }

        .batch-name {
            font-weight: 700;
            color: var(--text-primary);
            font-size: 1.1rem;
        }

        .stat {
            text-align: center;
            padding: 1rem;
            background: var(--bg-primary);
            border-radius: 16px;
            transition: all 0.3s ease;
        }

        .batch-row:hover .stat {
            background: var(--bg-secondary);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .progress-container {
            grid-column: 1 / -1;
            margin-top: 1rem;
        }

        .progress-bar {
            height: 8px;
            background: var(--bg-primary);
            border-radius: 4px;
            overflow: hidden;
        }

        .progress {
            height: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 4px;
            transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .details-btn1 {
            background: transparent;
            color: var(--primary);
            padding: 0.25rem 0.5rem;
            border: 2px solid var(--primary);
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .details-btn1:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }

        .modal1 {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(8px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content1 {
            background: var(--bg-secondary);
            padding: 2.5rem;
            border-radius: 24px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
            animation: modalSlideIn 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px) scale(0.95);
                opacity: 0;
            }

            to {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        .modal-header1 {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-title1 {
            font-size: 1.5rem;
            color: var(--text-primary);
            font-weight: 700;
        }

        .close-modal1 {
            background: var(--bg-primary);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 20px;
            cursor: pointer;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .close-modal1:hover {
            background: var(--border-color);
            color: var(--text-primary);
        }

        .mentor-list {
            display: grid;
            gap: 1rem;
        }

        .mentor-item {
            background: var(--bg-primary);
            padding: 1.5rem;
            border-radius: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .mentor-item:hover {
            transform: translateX(4px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .mentor-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 1.1rem;
        }

        .mentor-count {
            background: var(--primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);
        }

        .footer {
            text-align: right;
            color: var(--text-secondary);
            margin-top: 2rem;
            font-size: 0.875rem;
        }

        .error-message {
            display: none;
            text-align: center;
            padding: 1rem;
            margin: 1rem 0;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 12px;
            border: 1px solid #fecaca;
            animation: shake 0.5s cubic-bezier(.36, .07, .19, .97) both;
        }

        @keyframes shake {

            10%,
            90% {
                transform: translate3d(-1px, 0, 0);
            }

            20%,
            80% {
                transform: translate3d(2px, 0, 0);
            }

            30%,
            50%,
            70% {
                transform: translate3d(-4px, 0, 0);
            }

            40%,
            60% {
                transform: translate3d(4px, 0, 0);
            }
        }

        .loading {
            display: none;
            text-align: center;
            padding: 2rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .batch-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .stat {
                padding: 0.75rem;
            }

            .department-header {
                padding: 1.5rem;
            }

            .header {
                padding: 1.5rem;
            }

            .date-input-container {
                flex-direction: column;
            }

            .date-input {
                max-width: 100%;
            }
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
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Complaints</li>
                </ol>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form class="zmdi-format-valign-top">
                        <div class="card-body">
                            <h4 class="card-title">Complaint Details</h4>
                            <div class="card">
                                <div class="custom-tabs">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" data-bs-toggle="tab" id="edit-bus-tab" href="#dashboard" role="tab" aria-selected="true">
                                                <span class="hidden-xs-down" style="font-size: 0.9em;"><i class="fas fa-book tab-icon"></i></span><b>&nbsp Dashboard</b>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="tab" id="edit-bus-tab" href="#pending" role="tab" aria-selected="true">
                                                <span class="hidden-xs-down" style="font-size: 0.9em;"></span>
                                                <div id="navref1">
                                                    <span class="hidden-xs-down">
                                                        <i class="fas fa-clock"></i>
                                                        <b>&nbsp Pending (<?php echo $pending; ?>) </b>
                                                    </span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="tab" id="edit-bus-tab" href="#approved" role="tab" aria-selected="true">
                                                <span class="hidden-xs-down" style="font-size: 0.9em;"></span>
                                                <div id="navref2">
                                                    <span class="hidden-xs-down">
                                                        <i class="fas fa-check"></i>
                                                        <b>&nbsp Approved (<?php echo $approved; ?>) </b>
                                                    </span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="tab" id="edit-bus-tab" href="#completed" role="tab" aria-selected="true">
                                                <span class="hidden-xs-down" style="font-size: 0.9em;"></span>
                                                <div id="navref3">
                                                    <span class="hidden-xs-down">
                                                        <i class="fa-solid fa-check-double"></i>
                                                        <b>&nbsp Completed (<?php echo $completed; ?>) </b>
                                                    </span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="tab" id="edit-bus-tab" href="#rejected" role="tab" aria-selected="true">
                                                <span class="hidden-xs-down" style="font-size: 0.9em;"></span>
                                                <div id="navref4">
                                                    <span class="hidden-xs-down">
                                                        <i class="fa-solid fa-xmark"></i>
                                                        <b>&nbsp Rejected (<?php echo $rejected; ?>) </b>
                                                    </span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="tab" id="edit-bus-tab" href="#record" role="tab" aria-selected="true">
                                                <span class="hidden-xs-down" style="font-size: 0.9em;"></span>
                                                <div id="navref44">
                                                    <span class="hidden-xs-down">
                                                        <i class="mdi mdi-file-document"></i>
                                                        <b>&nbsp Record</b>
                                                    </span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="tab" id="edit-bus-tab" href="#feedback" role="tab" aria-selected="true">
                                                <span class="hidden-xs-down" style="font-size: 0.9em;"></span>
                                                <div id="navref33">
                                                    <span class="hidden-xs-down">
                                                        <i class="fa-solid fa-clipboard"></i>
                                                        <b>&nbsp Feedback (<?php echo $row_count11; ?>) </b>
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
                                                                            <i class="fa-solid fa-check-double"></i>
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
                                                                            <i class="fa-solid fa-xmark"></i>
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
                                                                <button type="button" class="btn btn-info float-end fac" data-bs-toggle="modal" data-bs-target="#raisemodal">Raise Complant</button>
                                                                <br>
                                                            </h4>
                                                        </div>

                                                        <div class="card-body">
                                                            <div class="table-container">
                                                                <table id="myTable1" class="table table-bordered table-striped fixed-size-table">
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th class="pending status text-center" style="width: 40px;">
                                                                                <b>S.No</b>
                                                                            </th>
                                                                            <th class="text-center" style="width: 80px;">
                                                                                <b>Date Registered</b>
                                                                            </th>
                                                                            <th class="text-center" style="width: 70px;">
                                                                                <b>Department / venue</b>
                                                                            </th>
                                                                            <th class="text-center">
                                                                                <b>Problem Description</b>
                                                                            </th>
                                                                            <th class="text-center">
                                                                                <b>Image</b>
                                                                            </th>
                                                                            <th class="text-center">
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
                                                                                <td class="text-center"><?php echo $row['dept'] ?> /
                                                                                    <?php echo $row['block_venue'] ?>
                                                                                </td>
                                                                                <td class="text-center"><button type="button"
                                                                                        value="<?php echo $row['id']; ?>"
                                                                                        class="btn viewcomplaint"
                                                                                        data-bs-value="<?php echo $row['fac_id']; ?>"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#complaintDetailsModal"><i
                                                                                            class="fas fa-eye"
                                                                                            style="font-size: 25px;"></i></button>
                                                                                </td>
                                                                                <td>
                                                                                    <center>
                                                                                        <button type="button"
                                                                                            class="btn showImage"
                                                                                            value="<?php echo $row['id']; ?>"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#imageModal1"
                                                                                            data-bs-task-id='<?php echo htmlspecialchars($row['id']); ?>'>
                                                                                            <i class="fas fa-image" style="font-size: 20px;"></i>
                                                                                        </button>
                                                                                    </center>
                                                                                </td>
                                                                                <td>
                                                                                    <center>
                                                                                        <button type="button"
                                                                                            value="<?php echo $row['id']; ?>"
                                                                                            id="detail_id"
                                                                                            class="btn btn-success btnapprove eomail">
                                                                                            <i class="fas fa-check"></i>
                                                                                        </button>
                                                                                        <button type="button"
                                                                                            value="<?php echo $row['id']; ?>"
                                                                                            class="btn btn-danger btnreject"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#rejectmodal">
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
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th class="pending status text-center" style="width: 40px;">
                                                                                <b>S.No</b>
                                                                            </th>
                                                                            <th class="text-center" style="width: 80px;">
                                                                                <b>Date Registered</b>
                                                                            </th>
                                                                            <th class="text-center" style="width: 70px;">
                                                                                <b>Department / venue</b>
                                                                            </th>
                                                                            <th class="text-center">
                                                                                <b>Problem Description</b>
                                                                            </th>
                                                                            <th class="text-center">
                                                                                <b>Image</b>
                                                                            </th>
                                                                            <th class="text-center">
                                                                                <b>Status</b>
                                                                            </th>
                                                                        </tr>
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
                                                                                <td class="text-center"><?php echo $row['dept'] ?> /
                                                                                    <?php echo $row['block_venue'] ?>
                                                                                </td>
                                                                                <td class="text-center"><button type="button"
                                                                                        value="<?php echo $row['id']; ?>"
                                                                                        class="btn viewcomplaint"
                                                                                        data-bs-value="<?php echo $row['fac_id']; ?>"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#complaintDetailsModal"><i
                                                                                            class="fas fa-eye"
                                                                                            style="font-size: 25px;"></i></button>
                                                                                </td>
                                                                                <td>
                                                                                    <center>
                                                                                        <button type="button"
                                                                                            class="btn showImage"
                                                                                            value="<?php echo $row['id']; ?>"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#imageModal1"
                                                                                            data-bs-task-id='<?php echo htmlspecialchars($row['id']); ?>'>
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
                                                                                            22 => 'Forwarded to Manager',
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
                                        <!------------------Feedback Table----------------->
                                        <div class="tab-pane p-20" id="feedback" role="tabpanel">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="feedbackTable" class="table table-bordered table-striped">
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th class="text-center"><b>S.No</b></th>
                                                                            <th class="text-center"><b>Problem ID</th>
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
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#extendModal"
                                                                                            data-bs-reason="<?php echo $row['extend_reason']; ?>">
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
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#aftercomp"
                                                                                        data-bs-imgs-id='<?php echo htmlspecialchars($row['id']); ?>'>
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
                                                                                    if ($row['status'] == 14) {
                                                                                    ?>
                                                                                        <button class="btn btn-success">Submitted</button>

                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <!-- Button to open the feedback modal -->
                                                                                        <button type="button" class="btn btn-info feedbackBtn" data-bs-problem-id="<?php echo $row['id']; ?>" data-bs-toggle="modal" data-bs-target="#feedback_modal">Feedback</button>

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

                                        <!-- Record Table -->

                                        <div class="tab-pane p-20 " id="record" role="tabpanel">
                                            <div class="p-20">
                                                <div class="table-responsive">

                                                    <h5 class="card-title">Work Record</h5>

                                                    <!-- Date Range Filter Form -->
                                                    <form class="data_filter_form" id="date-filter-form">
                                                        <div class="container">
                                                            <div class="header">
                                                                <div class="date-input-container">
                                                                    <input type="date" id="from_date" name="from_date" class="date-input" required>
                                                                    <input type="date" id="to_date" name="to_date" class="date-input" required>
                                                                    <button type="submit" class="btn1">
                                                                        <i class="fas fa-sync-alt"></i> Filter
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <div id="error-message" class="error-message">
                                                                <i class="fas fa-exclamation-circle"></i>
                                                                <span></span>
                                                            </div>

                                                            <div id="loading" class="loading">
                                                                <i class="fas fa-spinner fa-spin"></i> Loading data...
                                                            </div>

                                                        </div>
                                                    </form>

                                                    <!-- Download Button -->
                                                    <button id="download" class="btn btn-success"
                                                        style="float: right; padding: 10px 20px; background-color: #28a745; border: none; border-radius: 5px; color: white;">Download as Excel</button>
                                                    <br><br>

                                                    <h5 class="card-title">Work Completed Records</h5>

                                                    <!-- Table for Displaying Results -->
                                                    <table id="record_table" class="table table-striped table-bordered">
                                                        <thead class="gradient-header">
                                                            <tr>
                                                                <th class="text-center"><b>S.No</b></th>
                                                                <th class="text-center"><b>Work ID</b></th>
                                                                <th class="text-center"><b>Venue Details</b></th>
                                                                <th class="text-center"><b>Completed Details</b></th>
                                                                <th class="text-center"><b>Item No</b></th>
                                                                <th class="text-center"><b>Amount Spent</b></th>
                                                                <th class="text-center"><b>Faculty Feedback</b></th>
                                                                <th class="text-center"><b>Point</b></th>
                                                                <th class="text-center"><b>Completed On</b></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Rows will be dynamically added by jQuery -->
                                                        </tbody>
                                                    </table>
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
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th class="pending status text-center" style="width: 40px;">
                                                                                <b>S.No</b>
                                                                            </th>
                                                                            <th class="text-center" style="width: 80px;">
                                                                                <b>Date Registered</b>
                                                                            </th>
                                                                            <th class="text-center" style="width: 70px;">
                                                                                <b>Department / venue</b>
                                                                            </th>
                                                                            <th class="text-center">
                                                                                <b>Problem Description</b>
                                                                            </th>
                                                                            <th class="text-center">
                                                                                <b>Before Image</b>
                                                                            </th>
                                                                            <th class="text-center">
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
                                                                                <td class="text-center"><?php echo $row['dept'] ?> /
                                                                                    <?php echo $row['block_venue'] ?>
                                                                                </td>
                                                                                <td class="text-center"><button type="button"
                                                                                        value="<?php echo $row['id']; ?>"
                                                                                        class="btn viewcomplaint"
                                                                                        data-bs-value="<?php echo $row['fac_id']; ?>"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#complaintDetailsModal"><i
                                                                                            class="fas fa-eye"
                                                                                            style="font-size: 25px;"></i></button>
                                                                                </td>
                                                                                <td>
                                                                                    <center>
                                                                                        <button type="button"
                                                                                            class="btn showImage"
                                                                                            value="<?php echo $row['id']; ?>"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#imageModal1"
                                                                                            data-bs-task-id='<?php echo htmlspecialchars($row['id']); ?>'>
                                                                                            <i class="fas fa-image" style="font-size: 20px;"></i>
                                                                                        </button>
                                                                                    </center>
                                                                                </td>
                                                                                <td>
                                                                                    <center>
                                                                                        <button type="button"
                                                                                            value="<?php echo htmlspecialchars($row['id']); ?>"
                                                                                            class="btn viewafterimgcomp"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#aftercomp"
                                                                                            data-bs-imgs-id='<?php echo htmlspecialchars($row['id']); ?>'>
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
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th class="pending status text-center" style="width: 40px;">
                                                                                <b>S.No</b>
                                                                            </th>
                                                                            <th class="text-center" style="width: 80px;">
                                                                                <b>Date Registered</b>
                                                                            </th>
                                                                            <th class="text-center" style="width: 70px;">
                                                                                <b>Department / venue</b>
                                                                            </th>
                                                                            <th class="text-center">
                                                                                <b>Problem Description</b>
                                                                            </th>
                                                                            <th class="text-center">
                                                                                <b>Image</b>
                                                                            </th>
                                                                            <th class="text-center">
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
                                                                                <td class="text-center"><?php echo $row['dept'] ?> /
                                                                                    <?php echo $row['block_venue'] ?>
                                                                                </td>
                                                                                <td class="text-center"><button type="button"
                                                                                        value="<?php echo $row['id']; ?>"
                                                                                        class="btn viewcomplaint"
                                                                                        data-bs-value="<?php echo $row['fac_id']; ?>"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#complaintDetailsModal"><i class="fas fa-eye" style="font-size: 25px;"></i></button>
                                                                                </td>
                                                                                <td>
                                                                                    <center>
                                                                                        <button type="button"
                                                                                            value="<?php echo $row['id']; ?>"
                                                                                            class="btn showImage"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#imageModal1"
                                                                                            data-bs-task-id='<?php echo htmlspecialchars($row['id']); ?>'>
                                                                                            <i class="fas fa-image" style="font-size: 20px;"></i>
                                                                                        </button>
                                                                                    </center>
                                                                                </td>
                                                                                <td>
                                                                                    <center>
                                                                                        <button type="button" value="<?php echo $row['id']; ?>" class="btn btn-danger btnrejfeed" data-bs-toggle="modal"
                                                                                            data-bs-target="#problemrejected" id="rejectedfeedback">
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
                                        <!-------------------------------Table Ends Here------------------------------->
                                    </div>
                                    <!-- dashboard ends here -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include 'footer.php'; ?>
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
                    <button type="button" class="close" data-bs-dismiss="modal"
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
                            data-bs-dismiss="modal">Close</button>
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
                    <button class="spbutton" type="button" class="btn-close" data-bs-dismiss="modal"
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

    <!-- Complaint Details Modal -->
    <div class="modal fade" id="complaintDetailsModal" tabindex="-1" aria-labelledby="complaintDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header gradient-header text-white">
                    <h5 class="modal-title fw-bold">Complaint Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

                    <div class="row g-3">
                        <!-- Complaint Info Section -->
                        <div class="col-md-6">
                            <label class="fw-bold text-primary">Complaint ID</label>
                            <div class="text-dark"><b id="id"></b></div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-primary">Faculty Name</label>
                            <div class="text-dark"><b id="faculty_name"></b></div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-primary">Mobile Number</label>
                            <div class="text-dark"><b id="faculty_contact"></b></div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-primary">E-mail</label>
                            <div class="text-dark"><b id="faculty_mail"></b></div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-primary">Faculty ID</label>
                            <div class="text-dark"><b id="fac_id"></b></div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-primary">Faculty Infra Coordinator Name</label>
                            <div class="text-dark"><b id="fac_name"></b></div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-primary">Venue Name</label>
                            <div class="text-dark"><b id="venue_name"></b></div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-primary">Type of Problem</label>
                            <div class="text-dark"><b id="type_of_problem"></b></div>
                        </div>

                        <div class="col-12">
                            <label class="fw-bold text-primary">Problem Description</label>
                            <div class="alert alert-light border rounded p-3 text-dark">
                                <span id="problem_description"></span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal">Close</button>
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
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage2" src="" alt="After" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
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
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="bimg" src="" alt="Image Preview" style="max-width: 100%;" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="raisemodal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Raise Complaint</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"
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
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                                data-bs-dismiss="modal">Close</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Feedback Modal -->
    <div class="modal fade" id="feedback_modal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);background-color:#7460ee;">
                    <h5 class="modal-title" id="exampleModalLabel">Feedback Form</h5>
                    <button class="spbutton" type="button" class="btn-close" data-bs-dismiss="modal"
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
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
            $('.viewcomplaint').tooltip({
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
            $('#record_table').DataTable();
            $('#feedbackTable').DataTable();

        });

        $(document).on("click", ".btnreject", function(e) {
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
                    url: 'cms_backend.php?action=rejfeedbackeo',
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

        // Function to send mail
        function sendRejectionMail(id) {
            var user_type = "Estate Officer";
            $.ajax({
                type: "POST",
                url: "cms_mail.php",
                data: {
                    'reject_mail': true,
                    'id': id,
                    'user_type': user_type,
                },
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 200) {
                        console.log("Mail sent successfully!!");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Mail AJAX error:", error);
                }
            });
        }

        //approve button
        $(document).on('click', '.btnapprove', function(e) {
            e.preventDefault();

            var approveid = $(this).val();
            console.log(approveid);


            $.ajax({
                type: "POST",
                url: 'cms_backend.php?action=eoaccept',
                data: {
                    'approveid': approveid
                },
                success: function(response) {
                    console.log(response);
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

        });

        // Add Faculty complaints to database
        $(document).on('submit', '#addnewuser', function(e) {
            e.preventDefault(); // Prevent form from submitting normally
            var formData = new FormData(this);
            formData.append("hod", true);
            $.ajax({
                type: "POST",
                url: 'cms_backend.php?action=EOaddcomplaint',
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
        //jquerry for view complaint
        $(document).on("click", ".viewcomplaint", function(e) {
            e.preventDefault();
            var user_id = $(this).val();
            var fac_id = $(this).data("value");
            console.log(user_id);
            
            $.ajax({
                type: "POST",
                url: 'cms_backend.php?action=view_complaint',
                data: {
                    user_id: user_id,
                    fac_id: fac_id,
                },
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    console.log(res);
                    if (res.status == 404) {
                        alert(res.message);
                    } else {
                        //$('#student_id2').val(res.data.uid);
                        $("#id").text(res.data.id);
                        $("#type_of_problem").text(res.data.type_of_problem);
                        $("#problem_description").text(res.data.problem_description);
                        $("#faculty_name").text(res.data.fname);
                        $("#faculty_mail").text(res.data.email);
                        $("#faculty_contact").text(res.data.mobile);
                        $("#block_venue").text(res.data.block_venue);
                        $("#venue_name").text(res.data.venue_name);
                        $("#fac_name").text(res.data1.name);
                        $("#fac_id").text(res.data.faculty_id);

                        $("#complaintDetailsModal").modal("show");
                    }
                },
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

        //Rejected Tab Reason
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

        $(document).on("submit", "#date-filter-form", function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "cms_backend.php?action=workrecord",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 200) {
                        console.log("Data fetched successfully!");

                        // Clear the existing table rows
                        $("#record_table tbody").empty();

                        // Dynamically populate the table with new data
                        var data = res.data;
                        data.forEach((row, index) => {
                            var avgRating = row.average_rating !== "N/A" ? row.average_rating : "N/A";
                            $("#record_table tbody").append(`
                        <tr>
                            <td class="text-center">${index + 1}</td>
                            <td class="text-center">${row.id}</td>
                            <td class="text-center">Venue: ${row.block_venue} | <br>Problem: ${row.problem_description}</td>
                            <td class="text-center">Completed by: ${row.completed_by} | <br>Department: ${row.department}</td>
                            <td class="text-center">${row.itemno}</td>
                            <td class="text-center">${row.amount_spent}</td>
                            <td class="text-center">${row.feedback}<br>Ratings: ${row.rating}</td>
                            <td class="text-center">${row.point}</td>
                            <td class="text-center">${row.date_of_completion}</td>
                        </tr>
                    `);
                        });
                    } else {
                        console.log("Error fetching data: ", res.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                },
            });
        });

        $(document).on('click', ".eomail", function(e) {
            e.preventDefault();
            var id = $(this).val();
            console.log(id);
            $.ajax({
                type: "POST",
                url: "cms_mail.php",
                data: {
                    'eoapprove': true,
                    'id': id,
                },
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 200) {
                        console.log("Mail sent succesfully!!");
                    }
                }
            })
        });

        $(document).on('click', ".eomail", function(e) {
            e.preventDefault();
            var id = $(this).val();
            console.log(id);
            $.ajax({
                type: "POST",
                url: "cms_mail.php",
                data: {
                    'eoforward': true,
                    'id': id,
                },
                success: function(response) {

                }
            })
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
                        $('#navref2').load(location.href + " #navref2");
                        $('#navref3').load(location.href + " #navref3");
                        $('#navref33').load(location.href + " #navref33");

                        $('#navref4').load(location.href + " #navref4");
                        $('#navref44').load(location.href + " #navref44");

                        $('#dashref').load(location.href + " #dashref");

                        $('#myTable1').DataTable().destroy();
                        $("#myTable1").load(location.href + " #myTable1 > *", function() {
                            $('#myTable1').DataTable();
                        });

                        $('#feedbackTable').DataTable().destroy();
                        $("#feedbackTable").load(location.href + " #feedbackTable > *", function() {
                            $('#feedbackTable').DataTable();
                        });

                        $('#myTable2').DataTable().destroy();
                        $("#myTable2").load(location.href + " #myTable2 > *", function() {
                            $('#myTable2').DataTable();
                        });

                        $('#myTable3').DataTable().destroy();
                        $("#myTable3").load(location.href + " #myTable3 > *", function() {
                            $('#myTable3').DataTable();
                        });
                        $('#record_table').DataTable().destroy();
                        $("#record_table").load(location.href + " #record_table > *", function() {
                            $('#record_table').DataTable();
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

        //to download as xlsheet record table
        document.getElementById('download').addEventListener('click', function() {
            var wb = XLSX.utils.book_new();
            var ws = XLSX.utils.table_to_sheet(document.getElementById('record_table'));
            XLSX.utils.book_append_sheet(wb, ws, "Complaints Data");

            // Create and trigger the download
            XLSX.writeFile(wb, 'complaints_data.xlsx');
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
    <script src="script.js"></script>
</body>

</html>