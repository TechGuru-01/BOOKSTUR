<?php
include 'config.php';
session_start();

$status = "error";
$msg_text = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_id = $_SESSION['user_id'] ?? 0;
    $product_id = intval($_POST['product_id'] ?? 0);
    $product_name = trim($_POST['product_name'] ?? '');
    $product_type = trim($_POST['table_name'] ?? ''); 
    $price = floatval($_POST['price'] ?? 0);
    $quantity = intval($_POST['quantity'] ?? 1);
    $notes = trim($_POST['notes'] ?? '');
    $selected_size = $_POST['selected_size'] ?? null;
    $product_image = trim($_POST['product_image'] ?? '');

    if ($user_id <= 0 || $product_id <= 0 || empty($product_type)) {
        $msg_text = "Invalid Session or Product Data";
    } else {
        $conn->begin_transaction();

        $stock_column = "";
        if ($product_type === 'books' || $product_type === 'academic_tools') {
            $stock_column = "stock_quantity";
        } else {
            if (empty($selected_size)) {
                $msg_text = "Please Select a Size";
            } else {
                $size_lower = strtolower($selected_size);
                if ($size_lower === 's') {
                    $stock_column = "stock_s";
                } elseif (in_array($size_lower, ['xs', 'm', 'l', 'xl', '2xl', '3xl', '4xl'])) {
                    $stock_column = "stock_" . $size_lower;
                } else {
                    $msg_text = "Invalid Selected Size";
                }
            }
        }

        if ($stock_column !== "") {
            $check_stock = $conn->prepare("SELECT $stock_column FROM $product_type WHERE product_id = ? FOR UPDATE");
            $check_stock->bind_param("i", $product_id);
            $check_stock->execute();
            $stock_res = $check_stock->get_result()->fetch_assoc();

            if (!$stock_res || $stock_res[$stock_column] < $quantity) {
                $msg_text = "Insufficient stock!";
                $conn->rollback();
            } else {
                $update_stock = $conn->prepare("UPDATE $product_type SET $stock_column = $stock_column - ? WHERE product_id = ?");
                $update_stock->bind_param("ii", $quantity, $product_id);
                $update_stock->execute();

                $check_cart = $conn->prepare("SELECT cart_id, quantity FROM cart WHERE user_id = ? AND product_id = ? AND product_type = ? AND (size = ? OR (size IS NULL AND ? IS NULL))");
                $check_cart->bind_param("iisss", $user_id, $product_id, $product_type, $selected_size, $selected_size);
                $check_cart->execute();
                $cart_res = $check_cart->get_result();

                if ($cart_res->num_rows > 0) {
                    $existing = $cart_res->fetch_assoc();
                    $new_cart_qty = $existing['quantity'] + $quantity;
                    $update_cart = $conn->prepare("UPDATE cart SET quantity = ? WHERE cart_id = ?");
                    $update_cart->bind_param("ii", $new_cart_qty, $existing['cart_id']);
                    $update_cart->execute();
                } else {
                   $insert_cart = $conn->prepare("INSERT INTO cart (user_id, product_id, product_name, product_type, price, size, quantity, notes, product_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $insert_cart->bind_param("iissdsiss", $user_id, $product_id, $product_name, $product_type, $price, $selected_size, $quantity, $notes, $product_image);
                    $insert_cart->execute();
                }

                $conn->commit();
                $status = "success";
                $msg_text = "Product added to cart successfully!";
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode([
        'status' => $status,
        'msg' => $msg_text
    ]);
    exit;
}
?>