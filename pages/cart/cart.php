<?php
require_once '../../include/config.php';
require_once '../../include/auth_checker.php';

$status = "error";
$msg_text = "";

if (isset($_GET['action']) && $_GET['action'] === 'fetch') {
    header('Content-Type: application/json');
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id); 
    $stmt->execute();
    
    $result = $stmt->get_result();
    $items = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode(['success' => true, 'items' => $items]);
    exit;
}
if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['delete_id'])) {
    ob_clean();
    $delete_id = intval($_POST['delete_id']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("DELETE FROM cart WHERE cart_id = ? AND user_id = ?");

    if ($stmt === false) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'msg' => 'SQL Prepare Error: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("ii", $delete_id, $user_id);

    if ($stmt->execute()) {
        $status = "success";
        $msg_text = "Item removed successfully.";
    } else {
        $status = "error";
        $msg_text = "Execute failed: " . $stmt->error;
    }

    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'msg' => $msg_text]);
    exit;
}
if (isset($_POST['action']) && $_POST['action'] === 'clear_all') {
    ob_clean();
    header('Content-Type: application/json');
    
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    
    if ($stmt === false) {
        echo json_encode(['status' => 'error', 'msg' => 'SQL Prepare Error: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'msg' => 'Cart cleared successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Execute failed: ' . $stmt->error]);
    }
    exit;
}



if (isset($_POST['action']) && $_POST['action'] === 'place_order') {
    $user_id = $_SESSION['user_id'];
    $cart_ids = json_decode($_POST['cart_ids']); 
    $payment_method = $_POST['payment_method'];
    $notes = $_POST['notes'];
    $ids_for_sql = implode(',', array_map('intval', $cart_ids));

    $conn->begin_transaction();

    try {
        $cart_query = "SELECT product_id, product_name, product_image, price, quantity 
                       FROM cart WHERE cart_id IN ($ids_for_sql) AND user_id = $user_id";
        $cart_result = $conn->query($cart_query);
        
        if ($cart_result->num_rows === 0) {
            throw new Exception("No items found in cart.");
        }

        $total_amount = 0;
        $items_to_save = [];

        while ($item = $cart_result->fetch_assoc()) {
            $total_amount += ($item['price'] * $item['quantity']);
            $items_to_save[] = $item;
        }

        $stmt_order = $conn->prepare("INSERT INTO orders (user_id, total_amount, payment_method, order_notes, status) VALUES (?, ?, ?, ?, 'Pending')");
        $stmt_order->bind_param("idss", $user_id, $total_amount, $payment_method, $notes);
        $stmt_order->execute();
        $new_order_id = $conn->insert_id;
        $stmt_items = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, price, quantity) VALUES (?, ?, ?, ?, ?, ?)");
        
        foreach ($items_to_save as $item) {
            $stmt_items->bind_param("iisssi", 
                $new_order_id, 
                $item['product_id'], 
                $item['product_name'], 
                $item['product_image'], 
                $item['price'], 
                $item['quantity']
            );
            $stmt_items->execute();
        }

        $conn->query("DELETE FROM cart WHERE cart_id IN ($ids_for_sql) AND user_id = $user_id");
        $conn->commit();
        echo json_encode(['status' => 'success', 'msg' => 'Order placed! Check your history.']);

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['status' => 'error', 'msg' => $e->getMessage()]);
    }
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart | SSCR-C Bookstore</title>
    <link rel="stylesheet" href="../../component/navbar/navbar.css">
    <link rel="stylesheet" href="../../component/adminUtils/adminUtils.css">
    <link rel="stylesheet" href="../../component/footer/footer.css">
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="Cart.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
</head>
<body>
    <?php include '../../component/navbar/navbar.php'; ?>

    <?php include '../../component/cartHeader/cartHeader.php'; ?>

    <div class="cart-layout">
        <div class="cart-left-col">
            <?php include '../../component/cartItemsSection/cartItemsSection.php'; ?>
        </div>

        <div class="cart-right-col">
            <?php include '../../component/orderSummarySection/orderSummarySection.php'; ?>
        </div>
    </div>

    <?php include '../../component/paymentOverlay/paymentOverlay.php'; ?>

    <?php include '../../component/adminUtils/adminUtils.php'; ?>
    <?php include '../../component/footer/footer.php'; ?>

    <script src="../../icons/sweetalert2.all.min.js"></script>
    <script src="../../component/cartItemsSection/cartItemSection.js"></script>
    <script src="../../component/orderSummarySection/orderSummarySection.js"></script>
    <script src="../../component/adminUtils/adminUtils.js"></script>
    <script src="../../component/navbar/nav.js"></script>
</body>
</html>