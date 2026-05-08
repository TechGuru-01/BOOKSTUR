<?php 
$productType = $_GET['producttype'] ?? '';
?>
<div id="editModal" class="edit-modal-overlay" style="display:none;">
    <div class="edit-modal-box">
        <div class="modal-header">
            <?php 
                $displayTitle = str_replace('_', ' ', $currentTable); 
                $displayTitle = ucwords($displayTitle); 
            ?>
            <h2>Update <?php echo htmlspecialchars($displayTitle); ?></h2>
        </div>

        <form id="editForm" method="POST" action="../../include/editModalFunction.php" enctype="multipart/form-data">
            <input type="hidden" name="product_id" id="edit_id">
            <input type="hidden" name="producttype" id="edit_producttype" value="<?php echo htmlspecialchars($currentTable); ?>">

            <div class="edit-form-body">
                <div class="edit-upload-section">
                    <div class="edit-img-preview-container" onclick="document.getElementById('edit_file_input').click()">
                        <img id="edit_img_preview" src="" alt="Preview">
                    </div>
                    <input type="file" name="product_image" id="edit_file_input" style="display:none;" onchange="previewEditImage(this)">
                </div>

                <div class="edit-details-section">
                   
                        <div style="grid-column: span 2;">
                            <label>Product Name</label>
                            <input type="text" name="product_name" id="edit_name" class="edit-input-field" required>
                        </div>
                   

                    <div class="edit-row">
                        <div>
                            <label>Price (₱)</label>
                            <input type="number" step="0.01" name="price" id="edit_price" class="edit-input-field" required>
                        </div>
                        <div>
                            <label>Category</label>
                            <select name="category_id" id="edit_category" class="edit-input-field">
                                <?php
                                $cat_query = "SELECT * FROM categories ORDER BY category_name ASC";
                                $cat_result = mysqli_query($conn, $cat_query);
                                while($cat = mysqli_fetch_assoc($cat_result)) {
                                    echo "<option value='".$cat['category_id']."'>".$cat['category_name']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="edit-inventory-section" id="inventorySection">
                        <label>Inventory / Stocks</label>
                        <div style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 5px; border-radius: 5px; margin-top: 5px;">
                            <table class="edit-stock-table" style="width: 100%;">
                                <tbody id="stockTableBody">
                                    <!-- Dito mag-i-inject ang JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="input-group" style="margin-top: 15px;">
                        <label>Description</label>
                        <textarea id="edit_description" name="description" rows="3" placeholder="Optional details..." class="edit-input-field" style="width: 100%;"></textarea>
                    </div>
                    
                    <hr>
                    <div class="edit-modal-actions">
                        <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                        <button type="submit" class="btn-save">Save Changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>