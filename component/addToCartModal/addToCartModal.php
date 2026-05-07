<?php 
$productType = $_GET['producttype'] ?? '';
?>
<div id="addToCartModal" class="edit-modal-overlay"> <!-- Palit ID: addToCartModal -->
    <div class="edit-modal-box">
        <div class="modal-header">
        <?php 
            $displayTitle = str_replace('_', ' ', $currentTable); 
            $displayTitle = ucwords($displayTitle); 
        ?>
        <h2>
            Add <?php echo htmlspecialchars($displayTitle); ?> to Cart <!-- Text update -->
        </h2>
    </div>

        <!-- Action changed to addToCartFunction.php -->
        <form id="addToCartForm" method="POST" action="../../include/addToCartFunction.php" enctype="multipart/form-data">
            <input type="hidden" name="product_id" id="cart_product_id"> <!-- Palit ID: cart_product_id -->
            <input type="hidden" name="producttype" id="cart_producttype">
            <input type="hidden" name="table_name" id="cart_table">

            <div class="edit-form-body">
                <div class="edit-upload-section">
                    <div class="edit-img-preview-container">
                        <img id="cart_img_preview" src="" alt="Product Image"> <!-- Palit ID: cart_img_preview -->
                    </div>
                </div>

                <div class="edit-details-section">
                    <div class="edit-row">
                        <div style="grid-column: span 2;">
                            <label>Product Name</label>
                            <!-- Ginawa nating 'readonly' dahil hindi dapat binabago ng user ang name sa cart -->
                            <input type="text" name="product_name" id="cart_name" class="edit-input-field" readonly> 
                        </div>
                    </div>

                    <div class="edit-row">
                        <div>
                            <label>Price (₱)</label>
                            <input type="number" name="price" id="cart_price" class="edit-input-field" readonly>
                        </div>
                        <div>
                            <label>Category</label>
                            <input type="text" id="cart_category_name" class="edit-input-field" readonly>
                            <input type="hidden" name="category_id" id="cart_category_id">
                        </div>
                    </div>

                    <?php if ($productType == 'Books' || $productType == 'Academic tools'):?>
                        <div class="edit-row">
                            <div style="grid-column: span 2;">
                                <label>Quantity to Order</label> <!-- Text update -->
                                <input type="number" name="quantity" id="cart_qty" class="edit-input-field" min="1" value="1" required>
                            </div>
                        </div>
                    <?php else:?>
                        <div class="edit-inventory-section" id="cartInventorySection">
                            <table class="edit-stock-table">
                                <thead>
                                    <tr>
                                        <th>Select Size</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody id="cartStockTableBody">
                                    <tr>
                                        <td>Small</td>
                                        <td><input type="number" name="qty[S]" id="cart_qty_S" class="edit-input-field" min="0" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Medium</td>
                                        <td><input type="number" name="qty[M]" id="cart_qty_M" class="edit-input-field" min="0" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Large</td>
                                        <td><input type="number" name="qty[L]" id="cart_qty_L" class="edit-input-field" min="0" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>XL</td>
                                        <td><input type="number" name="qty[XL]" id="cart_qty_XL" class="edit-input-field" min="0" value="0"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php endif?>

                    <div class="input-group">
                        <label>Special Instructions / Notes</label> <!-- Text update -->
                        <textarea id="cart_notes" name="notes" rows="3" placeholder="e.g. Please wrap it nicely..."></textarea>
                    </div>
                    <hr>
                    <div class="edit-modal-actions">
                        <button type="button" class="edit-btn-cancel" onclick="closeCartModal()">Cancel</button>
                        <button type="submit" class="edit-btn-save" style="background-color: #28a745;">Add to Cart</button> <!-- Color change hint -->
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>