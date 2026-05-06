<header class="profile-header"style="background-image: url('../../src/admin_banner.jpg'); background-size: cover; background-position: center;">
    <div class="header-overlay"></div>
        <div class="profile-main-info">
            <div class="avatar-container">
                <img src="../../src/SSCRLogo1.png" alt="Profile">
            </div>
            <div class="user-titles">
                <h1><?php echo htmlspecialchars($current_user['full_name']); ?></h1>
                <p class="student-id">Student ID:<?php echo htmlspecialchars($current_user['student_number']); ?></p>
        </div>
    </div>
</header>