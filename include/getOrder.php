<?php
error_reporting(0);
ini_set('display_errors', 0);

require_once 'config.php';
require_once 'auth_checker.php';

ob_start();

header('Content-Type: application/json');

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$user_id = $_SESSION['user_id'] ?? 0;

if ($order_id > 0 && $user_id > 0) {
    $query = "SELECT oi.* FROM order_items oi 
              JOIN orders o ON oi.order_id = o.order_id 
              WHERE oi.order_id = ? AND o.user_id = ?";
              
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    ob_clean(); 
    echo json_encode(['items' => $items]);
    exit;
} else {
    ob_clean();
    echo json_encode(['items' => [], 'error' => 'Invalid Request']);
    exit;
}