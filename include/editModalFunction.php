<?php
require_once 'config.php';

$status = "error";
$msg_text = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $targetTable = strtolower(trim($_POST['producttype'] ?? ''));
    $product_name = trim($_POST['product_name'] ?? '');
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $description = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $stock_xs  = intval($_POST['stocks']['XS'] ?? 0);
    $stock_s   = intval($_POST['stocks']['S'] ?? 0);
    $stock_m   = intval($_POST['stocks']['M'] ?? 0);
    $stock_l   = intval($_POST['stocks']['L'] ?? 0);
    $stock_xl  = intval($_POST['stocks']['XL'] ?? 0);
    $stock_2xl = intval($_POST['stocks']['2XL'] ?? 0);
    $stock_3xl = intval($_POST['stocks']['3XL'] ?? 0);
    $stock_4xl = intval($_POST['stocks']['4XL'] ?? 0);

    $total_stock = $stock_xs + $stock_s + $stock_m + $stock_l + $stock_xl + $stock_2xl + $stock_3xl + $stock_4xl;
    $status_db = ($total_stock > 0) ? 'Available' : 'Out of Stock';
    
    if ($product_id <= 0 || empty($targetTable)) {
        header('Content-Type: application/json');
        echo json_encode(["status" => "error", "msg" => "Invalid Product ID or Table Name: $targetTable"]);
        exit;
    }

    $stmt_old = $conn->prepare("SELECT product_image FROM $targetTable WHERE product_id = ?");
    $stmt_old->bind_param("i", $product_id);
    $stmt_old->execute();
    $res_old = $stmt_old->get_result();
    $old_data = $res_old->fetch_assoc();
    $image_file_name = $old_data['product_image'] ?? '../../src/placeholder.jpg';

    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $upload_dir = __DIR__ . "/../src/uploads/products/";
        $file_ext = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));
        $new_file_name = time() . '_' . preg_replace("/[^a-zA-Z0-9]/", "_", $product_name) . '.' . $file_ext;
            
        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $upload_dir . $new_file_name)) {
            $image_file_name = $new_file_name; 
        }
    }

    try {
        if ($targetTable == 'books' || $targetTable == 'academic_tools'){
            $query = $conn->prepare("UPDATE $targetTable SET category_id=?, product_name=?, description=?, status=?, price=?, stock_quantity=?, product_image=? WHERE product_id=?");
            $query->bind_param("isssdssi", $category_id, $product_name, $description, $status_db, $price, $stock_s, $image_file_name, $product_id);
        } else {
            $query = $conn->prepare("UPDATE $targetTable SET 
                category_id = ?, 
                product_name = ?,
                description = ?, 
                status = ?, 
                price = ?, 
                stock_xs = ?,
                stock_s = ?, 
                stock_m = ?, 
                stock_l = ?, 
                stock_xl = ?, 
                stock_2xl = ?,
                stock_3xl = ?,
                stock_4xl = ?,
                product_image = ? 
                WHERE product_id = ?");

            $query->bind_param("isssdiiiiiiiisi", 
                $category_id,    
                $product_name,   
                $description,    
                $status_db,      
                $price,          
                $stock_xs,       
                $stock_s,        
                $stock_m,        
                $stock_l,        
                $stock_xl,       
                $stock_2xl,      
                $stock_3xl,      
                $stock_4xl,      
                $image_file_name, 
                $product_id
            );
        }

        if ($query->execute()){
            $status = "success";
            $msg_text = "Successfully Updated " . ucwords(str_replace('_', ' ', $targetTable));
        } else {
            $msg_text = "Update Error: " . $query->error;
        }
    } catch (Exception $e) {
        $status = "error";
        $msg_text = "System Error: " . $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode([
        'status' => $status,
        'msg' => $msg_text,
        'targetTable' => $targetTable
    ]);
    exit; 
}
?>