 <div id="profile-tab" class="tab-pane active">
    <div class="content-card">
        <div class="card-header">
        <h2>Personal Information</h2>
        <p>Verify and manage your <?php echo $is_admin ? 'Admin' : 'student'; ?> profile details.</p>
    </div>

    <div class="info-form">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" value="<?php echo htmlspecialchars($current_user['full_name']); ?>" readonly>
        </div>

        <div class="form-group">
            <label>Student ID Number</label>
            <input type="text" value="<?php echo htmlspecialchars($current_user['student_number']); ?>"readonly>
        </div>

        <div class="form-group">
            <label>Course / Program</label>
            <input type="text" value="<?php echo htmlspecialchars($current_user['course']); ?>"readonly>
        </div>

        <div class="form-group">
            <label>Account Status</label>
            <div class="status-badge <?php echo $is_admin ? 'admin' : ''; ?>">
                <span class="material-icons-outlined"><?php echo $is_admin ? 'security' : 'verified'; ?></span>
                <?php echo $is_admin ? 'System Administrator' : 'Verified Student'; ?>
            </div>
        </div>
    </div>
</div>
