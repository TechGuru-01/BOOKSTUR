<?php
$current_page = $_SERVER['PHP_SELF'];
$is_dashboard = (strpos($current_page, 'dashboard.php') !== false);
$home_url = $is_dashboard ? 'javascript:window.scrollTo({top: 0, behavior: \'smooth\'});' : '/BOOKSTUR/pages/dashboard/dashboard.php';
?>

<script>
    function toggleMobileMenu() {
        const nav = document.querySelector("nav");
        const navLinks = document.querySelector(".nav-links");
        const toggleBtn = document.querySelector(".mobile-menu-toggle");
        const body = document.body;

        const isActive = navLinks.classList.toggle("active");
        nav.classList.toggle("menu-open");
        body.classList.toggle("no-scroll");

        if (isActive) {
            toggleBtn.textContent = "close";
        } else {
            toggleBtn.textContent = "menu";
            // Reset all submenus when closing main menu
            document.querySelectorAll('.has-submenu').forEach(el => {
                el.classList.remove('open');
                const icon = el.querySelector('#submenu-toggle-icon');
                if (icon) icon.textContent = 'add';
            });
        }
    }

    function toggleSubmenu(header) {
        const parent = header.closest('.has-submenu');
        const icon = document.getElementById('submenu-toggle-icon'); // FORCE TARGET BY UNIQUE ID

        if (!parent) return;

        const isOpen = parent.classList.toggle('open');
        if (icon) {
            icon.textContent = isOpen ? 'remove' : 'add';
        }
    }
</script>

<nav id="top">
    <div class="logo">
        <a href="<?php echo $home_url; ?>">
            <img class="display-on-mobile" src="../../src/SSCRLogo1.png" width="50" height="50"
                style="vertical-align: middle;">
            <h2 class="hide-on-mobile" style="font-size: 20px; color: white; text-shadow: var(--text-outline);">
                <img src="../../src/SSCRLogo1.png" width="60" height="60" style="vertical-align: middle;">
                SSC-R Bookstore
            </h2>
        </a>
    </div>

    <!-- Mobile Menu Toggle -->
    <span class="material-icons-outlined mobile-menu-toggle" onclick="toggleMobileMenu()">menu</span>

    <ul class="nav-links">
        <li>
            <a href="<?php echo $home_url; ?>">
                <span class="material-icons-outlined">home</span> HOME
            </a>
        </li>

        <!-- Collapsible Shop Section -->
        <li class="has-submenu display-on-mobile">
            <div class="submenu-header" onclick="toggleSubmenu(this)">
                <span>
                    <span class="material-icons-outlined" style="pointer-events: none;">local_library</span>
                    SHOP CATEGORIES
                </span>
                <span class="material-icons-outlined" id="submenu-toggle-icon">add</span>
            </div>
            <ul class="submenu-list">
                <li><a href="../../pages/library/library.php" class="sub-btn">Books</a></li>
                <li><a href="../../pages/uniform/uniform.php" class="sub-btn">Uniforms</a></li>
                <li><a href="../../pages/apparel/apparel.php" class="sub-btn">Apparel</a></li>
                <li><a href="../../pages/other/other.php" class="sub-btn">Supplies</a></li>
            </ul>
        </li>

        <li>
            <a href="../../pages/cart/cart.php">
                <span class="material-icons-outlined">shopping_bag</span> CART
            </a>
        </li>
        <li>
            <a href="../../pages/profile/profile.php">
                <span class="material-icons-outlined">person</span> ACCOUNT
            </a>
        </li>
    </ul>
</nav>