
document.addEventListener("DOMContentLoaded", function () {
    // Cache DOM elements
    const loaderContainer = document.getElementById("loaderContainer");
    const contentWrapper = document.getElementById("contentWrapper");
    const hamburger = document.getElementById("hamburger");
    const sidebar = document.getElementById("sidebar");
    const mobileOverlay = document.getElementById("mobileOverlay");
    const userMenu = document.getElementById("userMenu");
    const dropdownMenu = userMenu?.querySelector(".dropdown-menu");
    const menuItems = document.querySelectorAll(".menu-item");
    const submenuItems = document.querySelectorAll(".submenu-item");

    let loadingTimeout;

    // Show and Hide Loader
    function hideLoader() {
        loaderContainer.classList.add("hide");
        contentWrapper.classList.add("show");
    }

    function showError() {
        console.error("Page load took too long or encountered an error");
    }

    loadingTimeout = setTimeout(showError, 10000);

    window.onload = function () {
        clearTimeout(loadingTimeout);
        setTimeout(hideLoader, 500);
    };

    window.onerror = function () {
        clearTimeout(loadingTimeout);
        showError();
        return false;
    };

    // Sidebar Toggle
    function toggleSidebar() {
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle("mobile-show");
            mobileOverlay.classList.toggle("show");
            document.body.classList.toggle("sidebar-open");
        } else {
            sidebar.classList.toggle("collapsed");
        }
    }

    // Handle Window Resize
    function handleResize() {
        if (window.innerWidth <= 768) {
            sidebar.classList.remove("collapsed", "mobile-show");
            mobileOverlay.classList.remove("show");
            document.body.classList.remove("sidebar-open");
        }
    }

    // Active Menu Item
    function setActiveMenuItem() {
        const currentPath = window.location.pathname.split("/").pop();

        [...menuItems, ...submenuItems].forEach((item) => {
            const itemPath = item.getAttribute("href")?.replace("/", "");
            item.classList.toggle("active", itemPath === currentPath);

            if (itemPath === currentPath) {
                const parentSubmenu = item.closest(".submenu");
                const parentMenuItem = parentSubmenu?.previousElementSibling;
                if (parentSubmenu && parentMenuItem) {
                    parentSubmenu.classList.add("active");
                    parentMenuItem.classList.add("active");
                }
            }
        });
    }

    // User Menu Dropdown
    userMenu?.addEventListener("click", (e) => {
        e.stopPropagation();
        dropdownMenu.classList.toggle("show");
    });

    document.addEventListener("click", () => {
        dropdownMenu?.classList.remove("show");
    });

    // Toggle Submenu
    document.querySelectorAll(".has-submenu").forEach((item) => {
        item.addEventListener("click", (e) => {
            e.preventDefault();
            const submenu = item.nextElementSibling;
            item.classList.toggle("active");
            submenu.classList.toggle("active");
        });
    });

    // Initialize Event Listeners
    if (hamburger && mobileOverlay) {
        hamburger.addEventListener("click", toggleSidebar);
        mobileOverlay.addEventListener("click", toggleSidebar);
    }

    window.addEventListener("resize", handleResize);

    // Run initial setup
    setActiveMenuItem();
});

