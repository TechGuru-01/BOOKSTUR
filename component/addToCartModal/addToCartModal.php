<?php 
$productType = $_GET['producttype'] ?? '';
?>

<div id="addToCartModal" class="edit-modal-overlay">
    <div class="edit-modal-box">
        <div class="modal-header">
            <?php 
                $displayTitle = str_replace('_', ' ', $currentTable); 
                $displayTitle = ucwords($displayTitle); 
            ?>
            <h2>Purchase <?php echo htmlspecialchars($displayTitle); ?> </h2>
        </div>

        <form id="addToCartForm" method="POST" action="../../include/addToCartFunction.php" enctype="multipart/form-data">
            <input type="hidden" name="product_id" id="cart_product_id">
            <input type="hidden" name="producttype" id="cart_producttype">
            <input type="hidden" name="table_name" id="cart_table">

            <div class="edit-form-body">
                <div class="edit-upload-section">
                    <div class="edit-img-preview-container">
                        <img id="cart_img_preview" src="" alt="Product Image">
                    </div>
                </div>

                <div class="edit-details-section">
                    <div class="edit-row">
                        <div style="grid-column: span 2;">
                            <label>Product Name</label>
                            <input type="text" name="product_name" id="cart_name" class="edit-input-field" readonly> 
                        </div>
                    </div>

                    

                    <?php if ($currentTable === 'books' || $currentTable === 'academic_tools'): ?>
                        <div class="edit-row">
                        <div>
                            <label>Price (₱)</label>
                            <input type="number" name="price" id="cart_price" class="edit-input-field" readonly>
                        </div>
                         <div >
                                <label>Quantity to Order</label>
                                <input type="number" name="quantity" id="cart_qty" class="edit-input-field" min="1" value="1" required>
                            </div>
                    </div>
                    <?php else: ?>
                        <div>
                            <label>Price (₱)</label>
                            <input type="number" name="price" id="cart_price" class="edit-input-field" readonly>
                        </div>
                        <div class="selection-container">
                            <label class="section-label">Select Size</label>
                            <div class="size-tiles-group">
                                <?php 
                                    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL'];
                                    foreach ($sizes as $size): 
                                ?>
                                    <label class="size-tile" data-size-key="stock_<?php echo strtolower($size); ?>">
                                        <input type="radio" name="selected_size" value="<?php echo $size; ?>" required>
                                        <span class="tile-label">
                                            <?php echo $size; ?>
                                            <span class="stock-display"></span> 
                                        </span>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <div class="qty-selection-row">
                                <label>Quantity:</label>
                                <input type="number" name="quantity" id="cart_qty_tile" class="edit-input-field qty-small" min="1" placeholder="0" required>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="input-group">
                        <label>Special Instructions / Notes</label>
                        <textarea id="cart_notes" name="notes" rows="3" placeholder="e.g. Please wrap it nicely..."></textarea>
                    </div>

                    <hr>

                    <div class="edit-modal-actions">
                        <button type="button" class="edit-btn-cancel" onclick="closeCartModal()">Cancel</button>
                        <button type="submit" class="edit-btn-save" style="background-color: #28a745;">Add to Cart</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>