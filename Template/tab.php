<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colorful Bus Management Tabs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
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

    /* Add Bus Tab */
    #add-bus-tab {
        background: radial-gradient(circle at top right, #FF6A00, #FF8C00);
        color: #fff;
        box-shadow: 0 4px 6px rgba(255, 105, 0, 0.3);
        transition: all 0.3s ease;
    }

    #add-bus-tab:not(.active) {
        background: #fff;
        color: #FF6A00;
        border: 2px solid #FF6A00;
    }

    #add-bus-tab:hover:not(.active) {
        background: radial-gradient(circle at top right, #FF6A00, #FF8C00);
        color: #fff;
        border-color: #FF6A00;
    }

    /* Edit Bus Tab */
    #edit-bus-tab {
        background: linear-gradient(45deg, #3498DB, #2ECC71);
        color: #fff;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    #edit-bus-tab:not(.active) {
        background: #fff;
        color: #3498DB;
        border: 2px solid #3498DB;
    }

    #edit-bus-tab:hover:not(.active) {
        background: linear-gradient(45deg, #3498DB, #2ECC71);
        color: #fff;
        border-color: #3498DB;
    }

    /* View Bus Tab */
    #view-bus-tab {
        background: conic-gradient(from 90deg, #1F77B4, #A8CBE1);
        color: #fff;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    #view-bus-tab:not(.active) {
        background: #fff;
        color: #1F77B4;
        border: 2px solid #1F77B4;
    }

    #view-bus-tab:hover:not(.active) {
        background: conic-gradient(from 90deg, #1F77B4, #A8CBE1);
        color: #fff;
        border-color: #1F77B4;
    }

    /* Delete Bus Tab */
    #delete-bus-tab {
        background: linear-gradient(45deg, #C0392B, #F1948A);
        color: #fff;
        box-shadow: 0 4px 6px rgba(192, 57, 43, 0.3);
        transition: all 0.3s ease;
    }

    #delete-bus-tab:not(.active) {
        background: #fff;
        color: #C0392B;
        border: 2px solid #C0392B;
    }

    #delete-bus-tab:hover:not(.active) {
        background: linear-gradient(45deg, #C0392B, #F1948A);
        color: #fff;
        border-color: #C0392B;
    }

    /* Schedule Bus Tab */
    #schedule-bus-tab {
        background: linear-gradient(45deg, #F1C40F, #F39C12);
        color: #fff;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    #schedule-bus-tab:not(.active) {
        background: #fff;
        color: #F1C40F;
        border: 2px solid #F1C40F;
    }

    #schedule-bus-tab:hover:not(.active) {
        background: linear-gradient(45deg, #F1C40F, #F39C12);
        color: #fff;
        border-color: #F1C40F;
    }

    /* Route Bus Tab */
    #route-bus-tab {
        background: linear-gradient(45deg, #9B59B6, #D5A6BD);
        color: #fff;
        box-shadow: 0 4px 6px rgba(155, 89, 182, 0.3);
        transition: all 0.3s ease;
    }

    #route-bus-tab:not(.active) {
        background: #fff;
        color: #9B59B6;
        border: 2px solid #9B59B6;
    }

    #route-bus-tab:hover:not(.active) {
        background: linear-gradient(45deg, #9B59B6, #D5A6BD);
        color: #fff;
        border-color: #9B59B6;
    }

    /* Report Bus Tab */
    #report-bus-tab {
        background: radial-gradient(circle at top left, #16A085, #48C9B0);
        color: #fff;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    #report-bus-tab:not(.active) {
        background: #fff;
        color: #16A085;
        border: 2px solid #16A085;
    }

    #report-bus-tab:hover:not(.active) {
        background: radial-gradient(circle at top left, #16A085, #48C9B0);
        color: #fff;
        border-color: #16A085;
    }

    /* Settings Bus Tab */
    #settings-bus-tab {
        background: linear-gradient(45deg, #E67E22, #D35400);
        color: #fff;
        box-shadow: 0 4px 6px rgba(230, 126, 34, 0.3);
        transition: all 0.3s ease;
    }

    #settings-bus-tab:not(.active) {
        background: #fff;
        color: #E67E22;
        border: 2px solid #E67E22;
    }

    #settings-bus-tab:hover:not(.active) {
        background: linear-gradient(45deg, #E67E22, #D35400);
        color: #fff;
        border-color: #E67E22;
    }

    /* Balance Bus Tab */
    #balance-bus-tab {
        background: linear-gradient(45deg, #2980B9, #AED6F1);
        color: #fff;
        box-shadow: 0 4px 6px rgba(41, 128, 185, 0.3);
        transition: all 0.3s ease;
    }

    #balance-bus-tab:not(.active) {
        background: #fff;
        color: #2980B9;
        border: 2px solid #2980B9;
    }

    #balance-bus-tab:hover:not(.active) {
        background: linear-gradient(45deg, #2980B9, #AED6F1);
        color: #fff;
        border-color: #2980B9;
    }

    /* Revenue Bus Tab */
    #revenue-bus-tab {
        background: conic-gradient(from 180deg, #E74C3C, #F1948A);
        color: #fff;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    #revenue-bus-tab:not(.active) {
        background: #fff;
        color: #E74C3C;
        border: 2px solid #E74C3C;
    }

    #revenue-bus-tab:hover:not(.active) {
        background: conic-gradient(from 180deg, #E74C3C, #F1948A);
        color: #fff;
        border-color: #E74C3C;
    }

    /* Maintenance Bus Tab */
    #maintenance-bus-tab {
        background: linear-gradient(45deg, #27AE60, #7DCEA0);
        color: #fff;
        box-shadow: 0 4px 6px rgba(39, 174, 96, 0.3);
        transition: all 0.3s ease;
    }

    #maintenance-bus-tab:not(.active) {
        background: #fff;
        color: #27AE60;
        border: 2px solid #27AE60;
    }

    #maintenance-bus-tab:hover:not(.active) {
        background: linear-gradient(45deg, #27AE60, #7DCEA0);
        color: #fff;
        border-color: #27AE60;
    }

    /* Staff Bus Tab */
    #staff-bus-tab {
        background: linear-gradient(45deg, #F39C12, #F7DC6F);
        color: #fff;
        box-shadow: 0 4px 6px rgba(243, 156, 18, 0.3);
        transition: all 0.3s ease;
    }

    #staff-bus-tab:not(.active) {
        background: #fff;
        color: #F39C12;
        border: 2px solid #F39C12;
    }

    #staff-bus-tab:hover:not(.active) {
        background: linear-gradient(45deg, #F39C12, #F7DC6F);
        color: #fff;
        border-color: #F39C12;
    }

    /* Drivers Bus Tab */
    #drivers-bus-tab {
        background: radial-gradient(circle at center, #A9A9A9, #808080);
        color: #fff;
        transition: all 0.3s ease;
    }

    #drivers-bus-tab:not(.active) {
        background: #fff;
        color: #A9A9A9;
        border: 2px solid #A9A9A9;
    }

    #drivers-bus-tab:hover:not(.active) {
        background: radial-gradient(circle at center, #A9A9A9, #808080);
        color: #fff;
        border-color: #A9A9A9;
    }

    /* Vehicle Info Bus Tab */
    #vehicle-info-bus-tab {
        background: linear-gradient(45deg, #8B4513, #D2691E);
        color: #fff;
        box-shadow: 0 4px 6px rgba(139, 69, 19, 0.3);
        transition: all 0.3s ease;
    }

    #vehicle-info-bus-tab:not(.active) {
        background: #fff;
        color: #8B4513;
        border: 2px solid #8B4513;
    }

    #vehicle-info-bus-tab:hover:not(.active) {
        background: linear-gradient(45deg, #8B4513, #D2691E);
        color: #fff;
        border-color: #8B4513;
    }

    /* Route Map Tab */
    #route-map-bus-tab {
        background: radial-gradient(circle at top left, #A52A2A, #D2B48C);
        color: #fff;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    #route-map-bus-tab:not(.active) {
        background: #fff;
        color: #A52A2A;
        border: 2px solid #A52A2A;
    }

    #route-map-bus-tab:hover:not(.active) {
        background: radial-gradient(circle at top left, #A52A2A, #D2B48C);
        color: #fff;
        border-color: #A52A2A;
    }

    /* User Feedback Bus Tab */
    #user-feedback-bus-tab {
        background: linear-gradient(45deg, #32CD32, #98FB98);
        color: #fff;
        box-shadow: 0 4px 6px rgba(50, 205, 50, 0.3);
        transition: all 0.3s ease;
    }

    #user-feedback-bus-tab:not(.active) {
        background: #fff;
        color: #32CD32;
        border: 2px solid #32CD32;
    }

    #user-feedback-bus-tab:hover:not(.active) {
        background: linear-gradient(45deg, #32CD32, #98FB98);
        color: #fff;
        border-color: #32CD32;
    }

    /* Emergency Contact Bus Tab */
    #emergency-contact-bus-tab {
        background: linear-gradient(45deg, #FF1493, #FF69B4);
        color: #fff;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    #emergency-contact-bus-tab:not(.active) {
        background: #fff;
        color: #FF1493;
        border: 2px solid #FF1493;
    }

    #emergency-contact-bus-tab:hover:not(.active) {
        background: linear-gradient(45deg, #FF1493, #FF69B4);
        color: #fff;
        border-color: #FF1493;
    }

    /* Fleet Management Bus Tab */
    #fleet-management-bus-tab {
        background: linear-gradient(45deg, #5F9EA0, #4682B4);
        color: #fff;
        box-shadow: 0 4px 6px rgba(95, 158, 160, 0.3);
        transition: all 0.3s ease;
    }

    #fleet-management-bus-tab:not(.active) {
        background: #fff;
        color: #5F9EA0;
        border: 2px solid #5F9EA0;
    }

    #fleet-management-bus-tab:hover:not(.active) {
        background: linear-gradient(45deg, #5F9EA0, #4682B4);
        color: #fff;
        border-color: #5F9EA0;
    }

    /* Maintenance Schedule Bus Tab */
    #maintenance-schedule-bus-tab {
        background: radial-gradient(circle at bottom right, #9932CC, #8A2BE2);
        color: #fff;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    #maintenance-schedule-bus-tab:not(.active) {
        background: #fff;
        color: #9932CC;
        border: 2px solid #9932CC;
    }

    #maintenance-schedule-bus-tab:hover:not(.active) {
        background: radial-gradient(circle at bottom right, #9932CC, #8A2BE2);
        color: #fff;
        border-color: #9932CC;
    }

    /* Insurance Bus Tab */
    #insurance-bus-tab {
        background: linear-gradient(45deg, #DAA520, #B8860B);
        color: #fff;
        box-shadow: 0 4px 6px rgba(218, 165, 32, 0.3);
        transition: all 0.3s ease;
    }

    #insurance-bus-tab:not(.active) {
        background: #fff;
        color: #DAA520;
        border: 2px solid #DAA520;
    }

    #insurance-bus-tab:hover:not(.active) {
        background: linear-gradient(45deg, #DAA520, #B8860B);
        color: #fff;
        border-color: #DAA520;
    }

    /* Trip Record Bus Tab */
    #trip-record-bus-tab {
        background: conic-gradient(from 180deg, #DC143C, #FF4500);
        color: #fff;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    #trip-record-bus-tab:not(.active) {
        background: #fff;
        color: #DC143C;
        border: 2px solid #DC143C;
    }

    #trip-record-bus-tab:hover:not(.active) {
        background: conic-gradient(from 180deg, #DC143C, #FF4500);
        color: #fff;
        border-color: #DC143C;
    }

    /* Fuel Consumption Bus Tab */
    #fuel-consumption-bus-tab {
        background: linear-gradient(45deg, #008B8B, #20B2AA);
        color: #fff;
        box-shadow: 0 4px 6px rgba(0, 139, 139, 0.3);
        transition: all 0.3s ease;
    }

    #fuel-consumption-bus-tab:not(.active) {
        background: #fff;
        color: #008B8B;
        border: 2px solid #008B8B;
    }

    #fuel-consumption-bus-tab:hover:not(.active) {
        background: linear-gradient(45deg, #008B8B, #20B2AA);
        color: #fff;
        border-color: #008B8B;
    }

    /* Route Planning Bus Tab */
    #route-planning-bus-tab {
        background: conic-gradient(from 135deg, #FF6347, #FF7F50);
        color: #fff;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    #route-planning-bus-tab:not(.active) {
        background: #fff;
        color: #FF6347;
        border: 2px solid #FF6347;
    }

    #route-planning-bus-tab:hover:not(.active) {
        background: conic-gradient(from 135deg, #FF6347, #FF7F50);
        color: #fff;
        border-color: #FF6347;
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
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="custom-tabs">
            <!-- Navigation Tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <!-- Tab 1 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="add-bus-tab" data-bs-toggle="tab" data-bs-target="#add-bus"
                        type="button" role="tab">
                        <i class="fas fa-bus tab-icon"></i>Add Bus
                    </button>
                </li>
                <!-- Tab 2 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="edit-bus-tab" data-bs-toggle="tab" data-bs-target="#edit-bus"
                        type="button" role="tab">
                        <i class="fas fa-edit tab-icon"></i>Edit Bus
                    </button>
                </li>
                <!-- Tab 3 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="view-bus-tab" data-bs-toggle="tab" data-bs-target="#view-bus"
                        type="button" role="tab">
                        <i class="fas fa-eye tab-icon"></i>View Bus
                    </button>
                </li>
                <!-- Tab 4 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="delete-bus-tab" data-bs-toggle="tab" data-bs-target="#delete-bus"
                        type="button" role="tab">
                        <i class="fas fa-trash-alt tab-icon"></i>Delete Bus
                    </button>
                </li>
                <!-- Tab 5 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="schedule-bus-tab" data-bs-toggle="tab" data-bs-target="#schedule-bus"
                        type="button" role="tab">
                        <i class="fas fa-calendar-alt tab-icon"></i>Schedule
                    </button>
                </li>
                <!-- Tab 6 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="route-bus-tab" data-bs-toggle="tab" data-bs-target="#route-bus"
                        type="button" role="tab">
                        <i class="fas fa-route tab-icon"></i>Routes
                    </button>
                </li>
                <!-- Tab 7 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="report-bus-tab" data-bs-toggle="tab" data-bs-target="#report-bus"
                        type="button" role="tab">
                        <i class="fas fa-chart-line tab-icon"></i>Reports
                    </button>
                </li>
                <!-- Tab 8 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="settings-bus-tab" data-bs-toggle="tab" data-bs-target="#settings-bus"
                        type="button" role="tab">
                        <i class="fas fa-cog tab-icon"></i>Settings
                    </button>
                </li>
                <!-- Tab 9 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="balance-bus-tab" data-bs-toggle="tab" data-bs-target="#balance-bus"
                        type="button" role="tab">
                        <i class="fas fa-balance-scale tab-icon"></i>Balance
                    </button>
                </li>
                <!-- Tab 10 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="revenue-bus-tab" data-bs-toggle="tab" data-bs-target="#revenue-bus"
                        type="button" role="tab">
                        <i class="fas fa-money-bill tab-icon"></i>Revenue
                    </button>
                </li>
                <!-- Tab 11 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="maintenance-bus-tab" data-bs-toggle="tab"
                        data-bs-target="#maintenance-bus" type="button" role="tab">
                        <i class="fas fa-tools tab-icon"></i>Maintenance
                    </button>
                </li>
                <!-- Tab 12 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="staff-bus-tab" data-bs-toggle="tab" data-bs-target="#staff-bus"
                        type="button" role="tab">
                        <i class="fas fa-user tab-icon"></i>Staff
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="drivers-bus-tab" data-bs-toggle="tab" data-bs-target="#drivers-bus"
                        type="button" role="tab">
                        <i class="fas fa-user-tie tab-icon"></i>Drivers Bus
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="vehicle-info-bus-tab" data-bs-toggle="tab"
                        data-bs-target="#vehicle-info-bus" type="button" role="tab">
                        <i class="fas fa-car tab-icon"></i>Vehicle Info
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="route-map-bus-tab" data-bs-toggle="tab" data-bs-target="#route-map-bus"
                        type="button" role="tab">
                        <i class="fas fa-map-marker-alt tab-icon"></i>Route Map
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="user-feedback-bus-tab" data-bs-toggle="tab"
                        data-bs-target="#user-feedback-bus" type="button" role="tab">
                        <i class="fas fa-comments tab-icon"></i>User Feedback
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="emergency-contact-bus-tab" data-bs-toggle="tab"
                        data-bs-target="#emergency-contact-bus" type="button" role="tab">
                        <i class="fas fa-phone-alt tab-icon"></i>Emergency Contact
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="fleet-management-bus-tab" data-bs-toggle="tab"
                        data-bs-target="#fleet-management-bus" type="button" role="tab">
                        <i class="fas fa-truck tab-icon"></i>Fleet Management
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="maintenance-schedule-bus-tab" data-bs-toggle="tab"
                        data-bs-target="#maintenance-schedule-bus" type="button" role="tab">
                        <i class="fas fa-calendar-check tab-icon"></i>Maintenance Schedule
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="insurance-bus-tab" data-bs-toggle="tab" data-bs-target="#insurance-bus"
                        type="button" role="tab">
                        <i class="fas fa-shield-alt tab-icon"></i>Insurance
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="trip-record-bus-tab" data-bs-toggle="tab"
                        data-bs-target="#trip-record-bus" type="button" role="tab">
                        <i class="fas fa-file-alt tab-icon"></i>Trip Record
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="fuel-consumption-bus-tab" data-bs-toggle="tab"
                        data-bs-target="#fuel-consumption-bus" type="button" role="tab">
                        <i class="fas fa-gas-pump tab-icon"></i>Fuel Consumption
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="route-planning-bus-tab" data-bs-toggle="tab"
                        data-bs-target="#route-planning-bus" type="button" role="tab">
                        <i class="fas fa-route tab-icon"></i>Route Planning
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="new-bus-tab" data-bs-toggle="tab" data-bs-target="#new-bus"
                        type="button" role="tab">
                        <i class="fas fa-bus tab-icon"></i>New Bus
                    </button>
                </li>
                <!-- Tab 2 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="update-bus-tab" data-bs-toggle="tab" data-bs-target="#update-bus"
                        type="button" role="tab">
                        <i class="fas fa-sync-alt tab-icon"></i>Update Bus
                    </button>
                </li>
                <!-- Tab 3 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="manage-bus-tab" data-bs-toggle="tab" data-bs-target="#manage-bus"
                        type="button" role="tab">
                        <i class="fas fa-cogs tab-icon"></i>Manage Bus
                    </button>
                </li>
                <!-- Tab 4 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="overview-bus-tab" data-bs-toggle="tab" data-bs-target="#overview-bus"
                        type="button" role="tab">
                        <i class="fas fa-tachometer-alt tab-icon"></i>Bus Overview
                    </button>
                </li>
                <!-- Tab 5 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="track-bus-tab" data-bs-toggle="tab" data-bs-target="#track-bus"
                        type="button" role="tab">
                        <i class="fas fa-map-marker-alt tab-icon"></i>Track Bus
                    </button>
                </li>
                <!-- Tab 6 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="history-bus-tab" data-bs-toggle="tab" data-bs-target="#history-bus"
                        type="button" role="tab">
                        <i class="fas fa-history tab-icon"></i>Bus History
                    </button>
                </li>
                <!-- Tab 7 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bus-logs-tab" data-bs-toggle="tab" data-bs-target="#bus-logs"
                        type="button" role="tab">
                        <i class="fas fa-file-alt tab-icon"></i>Bus Logs
                    </button>
                </li>
                <!-- Tab 8 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="maintenance-record-bus-tab" data-bs-toggle="tab"
                        data-bs-target="#maintenance-record-bus" type="button" role="tab">
                        <i class="fas fa-wrench tab-icon"></i>Maintenance Record
                    </button>
                </li>
                <!-- Tab 9 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="fuel-record-bus-tab" data-bs-toggle="tab"
                        data-bs-target="#fuel-record-bus" type="button" role="tab">
                        <i class="fas fa-gas-pump tab-icon"></i>Fuel Record
                    </button>
                </li>
                <!-- Tab 10 -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="service-history-bus-tab" data-bs-toggle="tab"
                        data-bs-target="#service-history-bus" type="button" role="tab">
                        <i class="fas fa-clipboard-list tab-icon"></i>Service History
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content">
                <div class="tab-pane fade show active" id="add-bus" role="tabpanel">
                    <?php include 'bus.php'; ?>
                </div>
                <div class="tab-pane fade" id="edit-bus" role="tabpanel">
                    <?php include 'editbus.php'; ?>
                </div>
                <div class="tab-pane fade" id="view-bus" role="tabpanel">
                    <?php include 'viewbus.php'; ?>
                </div>
                <div class="tab-pane fade" id="delete-bus" role="tabpanel">
                    <?php include 'deletebus.php'; ?>
                </div>
                <div class="tab-pane fade" id="schedule-bus" role="tabpanel">
                    <?php include 'schedulebus.php'; ?>
                </div>
                <div class="tab-pane fade" id="route-bus" role="tabpanel">
                    <?php include 'routebus.php'; ?>
                </div>
                <div class="tab-pane fade" id="report-bus" role="tabpanel">
                    <?php include 'reportbus.php'; ?>
                </div>
                <div class="tab-pane fade" id="settings-bus" role="tabpanel">
                    <?php include 'settingsbus.php'; ?>
                </div>
                <div class="tab-pane fade" id="balance-bus" role="tabpanel">
                    <?php include 'balancebus.php'; ?>
                </div>
                <div class="tab-pane fade" id="revenue-bus" role="tabpanel">
                    <?php include 'revenuebus.php'; ?>
                </div>
                <div class="tab-pane fade" id="maintenance-bus" role="tabpanel">
                    <?php include 'maintenancebus.php'; ?>
                </div>
                <div class="tab-pane fade" id="staff-bus" role="tabpanel">
                    <?php include 'staffbus.php'; ?>
                </div>
                <div class="tab-pane fade" id="drivers-bus" role="tabpanel">
                    <?php include 'driversbus.php'; ?>
                </div>
                <div class="tab-pane fade" id="vehicle-info-bus" role="tabpanel">
                    <?php include 'vehicleinfobus.php'; ?>
                </div>
                <div class="tab-pane fade" id="route-map-bus" role="tabpanel">
                    <?php include 'routemapbus.php'; ?>
                </div>
                <div class="tab-pane fade" id="user-feedback-bus" role="tabpanel">
                    <?php include 'userfeedbackbus.php'; ?>
                </div>
                <div class="tab-pane fade" id="emergency-contact-bus" role="tabpanel">
                    <?php include 'emergencycontactbus.php'; ?>
                </div>
                <div class="tab-pane fade" id="fleet-management-bus" role="tabpanel">
                    <?php include 'fleetmanagementbus.php'; ?>
                </div>
                <div class="tab-pane fade" id="maintenance-schedule-bus" role="tabpanel">
                    <?php include 'maintenanceschedulebus.php'; ?>
                </div>
                <div class="tab-pane fade" id="insurance-bus" role="tabpanel">
                    <?php include 'insurancebus.php'; ?>
                </div>
                <div class="tab-pane fade" id="trip-record-bus" role="tabpanel">
                    <?php include 'triprecordbus.php'; ?>
                </div>
                <div class="tab-pane fade" id="fuel-consumption-bus" role="tabpanel">
                    <?php include 'fuelconsumptionbus.php'; ?>
                </div>
                <div class="tab-pane fade" id="route-planning-bus" role="tabpanel">
                    <?php include 'routeplanningbus.php'; ?>
                </div>
                <div class="tab-pane fade" id="new-bus" role="tabpanel">
                    <!-- Content for New Bus -->
                </div>
                <div class="tab-pane fade" id="update-bus" role="tabpanel">
                    <!-- Content for Update Bus -->
                </div>
                <div class="tab-pane fade" id="manage-bus" role="tabpanel">
                    <!-- Content for Manage Bus -->
                </div>
                <div class="tab-pane fade" id="overview-bus" role="tabpanel">
                    <!-- Content for Bus Overview -->
                </div>
                <div class="tab-pane fade" id="track-bus" role="tabpanel">
                    <!-- Content for Track Bus -->
                </div>
                <div class="tab-pane fade" id="history-bus" role="tabpanel">
                    <!-- Content for Bus History -->
                </div>
                <div class="tab-pane fade" id="bus-logs" role="tabpanel">
                    <!-- Content for Bus Logs -->
                </div>
                <div class="tab-pane fade" id="maintenance-record-bus" role="tabpanel">
                    <!-- Content for Maintenance Record -->
                </div>
                <div class="tab-pane fade" id="fuel-record-bus" role="tabpanel">
                    <!-- Content for Fuel Record -->
                </div>
                <div class="tab-pane fade" id="service-history-bus" role="tabpanel">
                    <!-- Content for Service History -->
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>