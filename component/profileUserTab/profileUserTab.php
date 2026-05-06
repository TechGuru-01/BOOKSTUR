<?php $users_query = $conn->query("SELECT * FROM users WHERE course != 'Admin' ORDER BY full_name ASC");?>
    
<?php include "../../component/profileStatCard/profileStatCard.php"?>

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
                                        <button class="btn-icon reset" title="Reset Password" onclick="resetPassword(<?php echo $user['id']; ?>, '<?php echo $user['full_name']; ?>')">
                                            <span class="material-icons-outlined">restart_alt</span>
                                        </button>
                                        <button class="btn-icon delete" title="Delete User" onclick="deleteUser(<?php echo $user['id']; ?>, '<?php echo $user['full_name']; ?>')">
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