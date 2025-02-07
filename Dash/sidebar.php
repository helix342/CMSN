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
        background-image: url('image/pattern_h.png');
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
</style>

<div class="mobile-overlay" id="mobileOverlay"></div>
<div class="sidebar" id="sidebar">
    <div class="logo">
        <img src="image/mkce.png" alt="College Logo">
        <img class='s_logo' src="image/mkce_s.png" alt="College Logo">
    </div>

    <div class="menu">
        <a href="/dashboard" class="menu-item">
            <i class="fas fa-home text-primary"></i>
            <span>Dashboard</span>
        </a>

        <a href="/bus-management" class="menu-item">
            <i class="fas fa-bus text-warning"></i>
            <span>Bus Management</span>
        </a>

        <div class="menu-item has-submenu">
            <i class="fas fa-chart-bar text-success"></i>
            <span>Analytics</span>
        </div>
        <div class="submenu">
            <a href="/analytics/reports" class="menu-item">
                <i class="fas fa-chart-pie text-warning"></i>
                <span>Reports</span>
            </a>
            <a href="/analytics/statistics" class="menu-item">
                <i class="fas fa-chart-line text-info"></i>
                <span>Statistics</span>
            </a>
        </div>

        <div class="menu-item has-submenu">
            <i class="fas fa-users text-danger"></i>
            <span>Users</span>
        </div>
        <div class="submenu">
            <a href="/users/add" class="menu-item">
                <i class="fas fa-user-plus text-warning"></i>
                <span>Add User</span>
            </a>
            <a href="/users/manage" class="menu-item">
                <i class="fas fa-user-edit text-info"></i>
                <span>Manage Users</span>
            </a>
        </div>

        <a href="/settings" class="menu-item">
            <i class="fas fa-cog text-secondary"></i>
            <span>Settings</span>
        </a>
    </div>
</div>