<?php //include("h.php"); 
//require 'fconfig.php';



$query = "SELECT id,dept,role FROM faculty WHERE id='$s'";
$query_run = mysqli_query($db, $query);
if (mysqli_num_rows($query_run) > 0) {
    $row = mysqli_fetch_assoc($query_run);
    $dept = $row['dept'];
    $role = $row['role'];
    $fac_id = $row['id'];
}


?>

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
</style>

<div class="mobile-overlay" id="mobileOverlay"></div>
<div class="sidebar" id="sidebar">
    <div class="logo">
        <img src="../image/mkce.png" alt="College Logo">
        <img class='s_logo' src="../image/mkce_s.png" alt="College Logo">
    </div>

    <div class="menu">
        <?php
        if ($fac_id == 1141014) {
        ?>
        <a href="cms_eo.php" class="menu-item active">
            <i class="fas fa-exclamation-triangle icon-feedback"></i>
            <span>Greivances</span>
        </a>
        <?php
        }
        ?>
        <?php
        if ($fac_id == 1112001) {

        ?>
        <a href="cms_manager.php" class="menu-item">
            <i class="fas fa-exclamation-triangle icon-feedback"></i>
            <span>Greivances</span>
        </a>
        <?php
        }
        ?>
        <?php

        $infraquery = "SELECT * FROM faculty WHERE role='infra' AND id='$fac_id'";
        $infraqueryrun = mysqli_query($db, $infraquery);
        ?>
        <?php
        if (mysqli_num_rows($infraqueryrun) > 0) {

        ?>
        <a href="cms_infra.php" class="menu-item">
            <i class="fas fa-exclamation-triangle icon-feedback"></i>
            <span>Greivances</span>
        </a>
        <?php
        }
        ?>

        <?php
        if ($fac_id != 1141014 && $fac_id != 1112001 && mysqli_num_rows($infraqueryrun) == 0) {
        ?>
        <a href="cms_faculty.php" class="menu-item">
            <i class="fas fa-exclamation-triangle icon-feedback"></i>
            <span>Greivances</span>
        </a>
        <?php
        }
        ?>
    </div>
</div>

