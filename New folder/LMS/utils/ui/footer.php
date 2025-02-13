<style>
    /* Footer Styles */
    .footer {
        position: fixed;
        bottom: 0;
        left: var(--sidebar-width);
        right: 0;
        height: var(--footer-height);
        background: linear-gradient(45deg, #4e73df, #1cc88a);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center; 
        padding: 0 20px;
        transition: all 0.3s ease;
        z-index: 999;
    }

    .sidebar.collapsed+.content .footer {
        left: var(--sidebar-collapsed-width);
    }

    .footer-copyright {
        text-align: center;
    }

    .footer-links {
        display: flex;
        gap: 20px;
    }

    .footer-links a {
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .footer-links a:hover {
        opacity: 0.8;
    }

    .footer-content {
        display: flex;
        flex-direction: column;
        align-items: center; 
    }
</style>
<footer class="footer">
    <div class="footer-content">
        <div class="footer-copyright">
            <p>Copyright © 2024 Designed by <span style="background: linear-gradient(to right, #cb2d3e, #ef473a);"
                    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip:
                    text;">Technology Innovation Hub - MKCE.</span> All rights reserved.</p>
        </div>
        
    </div>
</footer>
