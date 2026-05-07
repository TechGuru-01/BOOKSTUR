<?php
$total_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE course != 'Admin'");
$row_total = mysqli_fetch_assoc($total_result);
$total_users = $row_total['total'];

$online_query = "SELECT COUNT(*) as online_count FROM users WHERE last_seen >= DATE_SUB(NOW(), INTERVAL 1 HOUR) AND course != 'Admin'";
$result_online = mysqli_query($conn, $online_query);
$row_online = mysqli_fetch_assoc($result_online);
$online_now = $row_online['online_count'];

$new_this_week_query = "SELECT COUNT(*) as new_count FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) AND course != 'Admin'";
$result_new_users = mysqli_query($conn, $new_this_week_query);
$row_new_users = mysqli_fetch_assoc($result_new_users);
$new_user = $row_new_users['new_count'];

$users_query = $conn->query("SELECT * FROM users WHERE course != 'Admin' ORDER BY full_name ASC");
?>

<div id="users-tab" class="tab-pane">
    <div class="stats-grid">
        <div class="stat-card">
            <span class="material-icons-outlined">people</span>
            <div>
                <h3><?php echo number_format($total_users) ?></h3>
                <p>Total Students</p>
            </div>
        </div>

        <div class="stat-card">
            <span class="material-icons-outlined">verified_user</span>
            <div>
                <h3><?php echo number_format($online_now) ?></h3>
                <p>Active Now</p>
            </div>
        </div>

        <div class="stat-card">
            <span class="material-icons-outlined">person_add</span>
            <div>
                <h3><?php echo number_format($new_user) ?></h3>
                <p>New This Week</p>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="card-header">
            <h2>User Management</h2>
            <p>View and manage all registered student accounts.</p>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Student ID</th>
                        <th>Course</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $users_query->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['student_number']); ?></td>
                            <td><?php echo htmlspecialchars($user['course']); ?></td>
                            <td>
                                <div class="action-btns">
                                    <button class="btn-icon reset" title="Reset Password" onclick="confirmReset(<?php echo $user['id']; ?>, '<?php echo addslashes($user['full_name']); ?>')">
                                        <span class="material-icons-outlined">restart_alt</span>
                                    </button>
                                    <button class="btn-icon delete" title="Delete User" onclick="confirmDelete(<?php echo $user['id']; ?>)">
                                        <span class="material-icons-outlined">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>