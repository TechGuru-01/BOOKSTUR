<?php
require_once '../../include/config.php';
require_once '../../include/auth_checker.php';

$user_id = $_SESSION['user_id'];
$user_query = $conn->prepare("SELECT * FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$current_user = $user_query->get_result()->fetch_assoc();

$is_admin = (strtolower($current_user['course'] ?? '') == 'admin');


$status = "";
$msg_text = "";
$default_password = "Sscr1966!";

if($is_admin){
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    $delete_query = $conn->prepare("DELETE FROM users WHERE id = ?");
    $delete_query->bind_param("i", $id);
    
    $status = "error";
    $msg_text = "Error: This user cannot be deleted.";
    
    if ($delete_query->execute()) {
        $status = "success";
        $msg_text = "User has been deleted successfully.";
    }
    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'msg' => $msg_text]);
    exit; 
}

if (isset($_GET['reset_id'])) {
    $id = (int)$_GET['reset_id'];
    $full_name = $_GET['full_name'] ?? 'User';
    $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);

    $reset_password_query = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $reset_password_query->bind_param("si", $hashed_password, $id);

    $status = "error";
    $msg_text = "Database Error: Could not reset password.";

    if ($reset_password_query->execute()) {
        $status = "success"; 
        $msg_text = "The password for " . $full_name . " has been reset successfully.";
    }
      header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'msg' => $msg_text]);
    exit; 
}

}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'change_password') {
    ob_clean();
    header('Content-Type: application/json');
    
    $current_pass = $_POST['current_password'] ?? '';
    $new_pass = $_POST['new_password'] ?? '';
    
    if (empty($current_pass) || empty($new_pass)) {
        echo json_encode(['status' => 'error', 'msg' => 'Please fill in all fields.']);
        exit;
    }


    if (strlen($new_pass) < 8) {
        $status = "error";
        $msg_text = "Password should at least be 8 characters long.";
    } elseif (!preg_match('/[A-Z]/', $new_pass)) {
        $status = 'error';
        $msg_text = 'Password must include at least one upper case letter.';
    } elseif (!preg_match('/[a-z]/', $new_pass)) {
        $status = 'error';
        $msg_text = 'Password must include at least one lower case letter.';
    } elseif (!preg_match('/\d/', $new_pass)) {
        $status = 'error';
        $msg_text = 'Password must include at least one number.';
    } elseif (!preg_match('/[$#@!?]/', $new_pass)) {
        $status = 'error';
        $msg_text = 'Password must include at least one special character ($#@!?)';
    }

    if ($status === "error") {
        echo json_encode(['status' => 'error', 'msg' => $msg_text]);
        exit;
    }

    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if (password_verify($current_pass, $result['password'])) {
        $new_hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);
        $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update_stmt->bind_param("si", $new_hashed_password, $user_id);
        
        if ($update_stmt->execute()) {
            echo json_encode(['status' => 'success', 'msg' => 'Password updated successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Database error.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Incorrect current password.']);
    }
    exit;
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
    <link rel="stylesheet" href="../../component/profileUserTab/profileUserTab.css">
    <link rel="stylesheet" href="../../component/logoutModal/logoutModal.css">
    <link rel="stylesheet" href="../../component/addItems/addItems.css">
    <link rel="stylesheet" href="../../component/adminUtils/adminUtils.css">
    <link rel="stylesheet" href="profile.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
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
                    <?php include "../../component/profileTab/profileTab.php" ?>
                    <?php if ($is_admin): ?>
                        <?php include "../../component/profileUserTab/profileUserTab.php" ?>
                    <?php else: ?>
                        <?php include "../../component/profileTransactionTab/profileTransactionTab.php" ?>        
                    <?php endif; ?>
                    <?php include "../../component/profileSettingsTab/profileSettingsTab.php" ?>
                </div>
            </div>
        </section>
    </main>
    <?php if ($is_admin):?>
    <?php include "../../component/adminUtils/adminUtils.php"?>
    <?php include "../../component/addItems/addItems.php"?>
    <?php endif?>
    <?php include "../../component/logoutModal/logoutModal.php"?>                   
    <?php include '../../component/footer/footer.php' ?>
    

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <script src="profile.js"></script>
        <script src = "../../component/profileUserTab/profileUserTab.js"></script>
        <script src="../../component/navbar/nav.js"></script>
        <script src="../../component/profileSettingsTab/profileSetting.js"></script>
        <script src="../../component/addItems/addItems.js"></script>
        <script src="../../component/adminUtils/adminUtils.js"></script>
        <script src="../../component/logoutModal/logoutModal.js"></script>
        <script>
            function switchTab(tabId, btn) {
                document.querySelectorAll('.tab-pane').forEach(tab => tab.classList.remove('active'));
                document.querySelectorAll('.nav-btn').forEach(nav => nav.classList.remove('active'));
                document.getElementById(tabId + '-tab').classList.add('active');
                btn.classList.add('active');
            }
        </script> 
</body>

</html>