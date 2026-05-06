<?php 
$total_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$row_total = mysqli_fetch_assoc($total_result);
$total_users = $row_total['total'];

$online_query = "SELECT COUNT(*) as online_count FROM users WHERE last_seen >= DATE_SUB(NOW(), INTERVAL 1 HOUR)";
$result_online = mysqli_query($conn, $online_query);
$row_online = mysqli_fetch_assoc($result_online);
$online_now = $row_online['online_count'];

$new_this_week_query = "SELECT COUNT(*) as new_count FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
$result_new_users = mysqli_query($conn, $new_this_week_query);
$row_new_users = mysqli_fetch_assoc($result_new_users);
$new_user = $row_new_users['new_count'];

?>
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