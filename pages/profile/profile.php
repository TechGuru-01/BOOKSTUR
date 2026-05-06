<?php
require_once '../../include/config.php';
require_once '../../include/auth_checker.php';

// Fetch current user details
$user_id = $_SESSION['user_id'];
$user_query = $conn->prepare("SELECT * FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$current_user = $user_query->get_result()->fetch_assoc();

$is_admin = (strtolower($current_user['course'] ?? '') == 'admin');

if ($is_admin) {
    $status = "error";
    $msg_text = "";

    
   

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $delete_query = $conn->prepare("DELETE FROM users WHERE id = ?");
        $delete_query->bind_param("i", $id);
        if ($delete_query->execute()) {
            $status = "success";
            $msg_text = "User has been deleted successfully";
        } else {
            $status = "error";
            $msg_text = "Error: this user cannot be deleted";
        }
        header('Content-Type: application/json');
        echo json_encode([
            'status' => $status,
            'msg' => $msg_text
        ]);
        exit;
    }
    // Magkasama dapat ito sa taas ng profile.php kasama ng Delete logic
    if (isset($_GET['reset_id']) && isset($_GET['new_password'])) {
        $id = (int) $_GET['reset_id'];
        $new_pass = $_GET['new_password'];

        // I-hash ang bagong password
        $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);

        $update_query = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update_query->bind_param("si", $hashed_password, $id);

        $status = "error";
        $msg_text = "Failed to update password.";

        if ($update_query->execute()) {
            $status = "success";
            $msg_text = "Password updated successfully.";
        }

        header('Content-Type: application/json');
        echo json_encode(['status' => $status, 'msg' => $msg_text]);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../component/navbar/navbar.css">
    <link rel="stylesheet" href="../../component/footer/footer.css">
    <link rel="stylesheet" href="../../component/profileHeader/profileHeader.css">
    <link rel="stylesheet" href="../../component/profileNav/profileNav.css">
    <link rel="stylesheet" href="../../component/profileTab/profileTab.css">
    <link rel="stylesheet" href="../../component/profileUserTab/profileUserTab.css">
    <link rel="stylesheet" href="../../component/profileStatCard/profileStatCard.css">
    <link rel="stylesheet" href="../../component/logoutModal/logoutModal.css">
    <link rel="stylesheet" href="profile.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined" rel="stylesheet">
    <title>Account | SSCR-C Bookstore</title>
</head>
<body>
    <?php include '../../component/navbar/navbar.php' ?>

    <main class="account-wrapper">
        <section class="account-main">
            <?php include "../../component/profileHeader/profileHeader.php"?>
            
            <div class="dashboard-grid">
                    <?php include "../../component/profileNav/profileNav.php"?>
                    <div class="tab-content-wrapper">
                        <?php include "../../component/profileTab/profileTab.php"?>
                    </div>
                
                    <?php if ($is_admin): ?>
                        <?php include "../../component/profileUserTab/profileUserTab.php"?>
                    <?php else: ?>
                        <?php include "../../component/profileTransactionTab/profileTransactionTab.php"?>        
                    <?php endif; ?>

                   <?php include "../../component/profileSettingsTab/profileSettingsTab.php"?>
            </div>
        </section>
    </main>
    <?php include "../../component/logoutModal/logoutModal.php"?>                   
    <?php include '../../component/footer/footer.php' ?>
    <script src="profile.js"></script>
    <script src="../../component/navbar/nav.js"></script>
    <script src="../../component/logoutModal/logoutModal.js"></script>
    <script>
        function switchTab(tabId, btn) {
            document.querySelectorAll('.tab-pane').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.nav-btn').forEach(nav => nav.classList.remove('active'));
            document.getElementById(tabId + '-tab').classList.add('active');
            btn.classList.add('active');
        }
    </script>

    <!-- Logout Confirmation Modal -->
 
</body>

</html>