<?php
header('Content-Type: application/json');
require_once 'config.php';

$response = ['items' => [], 'total_amount' => 0];

if (isset($_GET['order_id'])) {
    $order_id = preg_replace('/[^0-9]/', '', $_GET['order_id']); 
    $order_id = intval($order_id);

    $query = "SELECT product_name, product_image, quantity, price 
              FROM order_items 
              WHERE order_id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $total = 0;
    while ($row = $result->fetch_assoc()) {
        $qty = intval($row['quantity'] ?? 1); 
        $price = floatval($row['price']);
        $total += ($qty * $price);

        $response['items'][] = [
            'product_name' => $row['product_name'],
            'product_image' => $row['product_image'],
            'quantity' => $qty,
            'price' => $price
        ];
    }

    $response['total_amount'] = $total;
    
    if (empty($response['items'])) {
        $response['debug_info'] = "No items found for ID: " . $order_id;
    }

    echo json_encode($response);
} else {
    echo json_encode(['error' => 'No ID provided']);
}
?>