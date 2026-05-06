<div id="users-tab" class="tab-pane">
    <div class="stats-grid">
        <div class="stat-card">
            <span class="material-icons-outlined">people</span>
        <div>
            <h3><?php echo number_format($total_users)?></h3>
            <p>Total Registered</p>
        </div>
    </div>
            
    <div class="stat-card">
        <span class="material-icons-outlined">verified_user</span>
        <div>
            <h3><?php echo number_format($online_now)?></h3>
            <p>Active Accounts</p>
        </div>
    </div>
            
    <div class="stat-card">
        <span class="material-icons-outlined">person_add</span>
        <div>
            <h3><?php echo number_format($new_user)?></h3>
            <p>New This Week</p>
        </div>
    </div>
</div>