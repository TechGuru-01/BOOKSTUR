<?php 
$productType = $_GET['producttype'] ?? '';
?>

<div id="addToCartModal" class="edit-modal-overlay" style="display:none;">
    
    <div class="edit-modal-box">
         <div class="modal-header">
            <div>
                <span class="modal-subtitle">SSCR Bookstore</span>
                <?php 
                    $displayTitle = str_replace('_', ' ', $currentTable); 
                    $displayTitle = ucwords($displayTitle); 
                ?>
                <h2>Purchase <?php echo htmlspecialchars($displayTitle); ?></h2>
            </div>
          </div>
           
        
        <form id="addToCartForm" method="POST" action="../../include/addToCartFunction.php">
            <!-- Hidden Fields para sa Backend -->
            <input type="hidden" name="product_id" id="cart_product_id">
            <input type="hidden" name="table_name" id="cart_table">
           <input type="hidden" name="product_image" id="cart_product_image">

            <div class="edit-form-body">
                <!-- Image Preview -->
                <div class="edit-upload-section">
                    <div class="edit-img-preview-container">
                        <img id="cart_img_preview" src="" alt="Product Image">
                    </div>
                </div>

                <div class="edit-details-section">
                    <div class="input-group">
                        <label>Product Name</label>
                        <input type="text" name="product_name" id="cart_name" class="edit-input-field" readonly>
                    </div>

                    <div class="edit-row">
                        <div class="input-group">
                            <label>Price (₱)</label>
                            <input type="number" name="price" id="cart_price" class="edit-input-field" readonly>
                        </div>

                        <!-- ITO YUNG DISPLAY NG STOCK -->
                        <div class="input-group">
                            <label>Available Stock</label>
                            <!-- Ginamit ang ID na 'stock_quantity' para sa parehong condition -->
                            <input type="text" id="stock_quantity" class="edit-input-field" readonly style="font-weight: bold; background-color: #f9f9f9;">
                        </div>
                    </div>

                    <!-- CONDITIONAL SECTION: SIZES VS QUANTITY ONLY -->
                    <!-- Hanapin mo 'tong part na 'to sa code mo at palitan ng ganito -->

                    <?php if ($productType !== 'books'): // Ipakita lang ang sizes kung HINDI books ?>
                        <div id="size-selection-area">
                            <label class="section-label">Select Size</label>
                            <div class="size-tiles-group">
                                <?php 
                                    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL'];
                                    foreach ($sizes as $size): 
                                        $columnName = "stock_" . strtolower($size);
                                ?>
                                    <label class="size-tile" data-size-key="<?php echo $columnName; ?>">
                                        <input type="radio" name="selected_size" value="<?php echo $size; ?>" 
                                            <?php echo ($productType !== 'books') ? 'required' : ''; ?>>
                                        <span class="tile-label">
                                            <?php echo $size; ?>
                                            <span class="stock-display"></span> 
                                        </span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="input-group" style="margin-top: 15px;">
                        <label>Quantity to Order</label>
                        <input type="number" name="quantity" id="order_quantity" class="edit-input-field" min="1" value="1" required>
                    </div>

                    <div class="input-group">
                        <label>Special Instructions</label>
                        <textarea name="notes" id="cart_notes" rows="2" placeholder="e.g., wrap it as a gift..."></textarea>
                    </div>

                    <div class="edit-modal-actions">
                        <button type="button" class="btn-cancel" onclick="closeCartModal()">Cancel</button>
                        <button type="submit" class="btn-save" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2.2" stroke-linecap="round"
                                 stroke-linejoin="round" aria-hidden="true">
                                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0
                                         0 2-1.61L23 6H6"/>
                            </svg>    
                        Add to Cart</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>