
<?php 

?>
<aside class="dashboard-sidebar">
    <div class="identity-pill">
        <div class="pill-brand"> <span class="material-icons-outlined">account_circle</span>ACCOUNT</div>
    </div>

    <div class="nav-pill-box">
        <nav class="vertical-nav">
            <button class="nav-btn active" onclick="switchTab('profile', this)">
                <span class="material-icons-outlined">person</span>
                My Profile
            </button>

            <?php if ($is_admin): ?>
                <button class="nav-btn" onclick="switchTab('users', this)">
                    <span class="material-icons-outlined">manage_accounts</span>
                        User Manager
                </button>
            <?php else: ?>
                <button class="nav-btn" onclick="switchTab('transactions', this)">
                    <span class="material-icons-outlined">receipt_long</span>
                        Transactions
                 </button>
            <?php endif; ?>

            <button class="nav-btn" onclick="switchTab('settings', this)">
                <span class="material-icons-outlined">settings</span>
                    Settings
             </button>

            <button type="button" class="nav-btn logout" onclick="showLogoutModal()">
                <span class="material-icons-outlined">logout</span>
                    Logout
                </button>
        </nav>
    </div>
</aside>