function openEditModal(product) {
  const modal = document.getElementById("editModal");
  const stockTableBody = document.getElementById("stockTableBody");

  if (!modal || !stockTableBody) {
    console.error("Critical Error: Modal elements not found!");
    return;
  }

  document.getElementById("edit_id").value = product.product_id || product.id;
  const tableInput =
    document.getElementById("edit_producttype") ||
    document.getElementById("edit_table");
  if (tableInput) tableInput.value = product.table;

  document.getElementById("edit_name").value = product.product_name || "";
  document.getElementById("edit_price").value = product.price || 0;
  document.getElementById("edit_category").value = product.category_id || "";
  document.getElementById("edit_description").value = product.description || "";

  const preview = document.getElementById("edit_img_preview");
  const path = "../../src/uploads/products/";
  const imgName = product.product_image || product.img;
  preview.src = imgName ? path + imgName : "../../src/placeholder.jpg";

  const tableName = (product.table || "").toLowerCase();

  if (
    product.is_book ||
    tableName === "books" ||
    tableName === "academic_tools"
  ) {
    stockTableBody.innerHTML = `
            <tr>
                <td><strong>Quantity</strong></td>
                <td><input type="number" name="stock_quantity" id="stock_quantity" class="edit-input-field" min="0" value="${product.stock_quantity || 0}"></td>
            </tr>
        `;
  } else {
    stockTableBody.innerHTML = `
            <tr><td>Extra Small</td><td><input type="number" name="stocks[XS]" id="stock_XS" class="edit-input-field" value="${product.stock_xs || 0}"></td></tr>
            <tr><td>Small</td><td><input type="number" name="stocks[S]" id="stock_S" class="edit-input-field" value="${product.stock_s || 0}"></td></tr>
            <tr><td>Medium</td><td><input type="number" name="stocks[M]" id="stock_M" class="edit-input-field" value="${product.stock_m || 0}"></td></tr>
            <tr><td>Large</td><td><input type="number" name="stocks[L]" id="stock_L" class="edit-input-field" value="${product.stock_l || 0}"></td></tr>
            <tr><td>XL</td><td><input type="number" name="stocks[XL]" id="stock_XL" class="edit-input-field" value="${product.stock_xl || 0}"></td></tr>
            <tr><td>2XL</td><td><input type="number" name="stocks[2XL]" id="stock_2XL" class="edit-input-field" value="${product.stock_2xl || 0}"></td></tr>
            <tr><td>3XL</td><td><input type="number" name="stocks[3XL]" id="stock_3XL" class="edit-input-field" value="${product.stock_3xl || 0}"></td></tr>
            <tr><td>4XL</td><td><input type="number" name="stocks[4XL]" id="stock_4XL" class="edit-input-field" value="${product.stock_4xl || 0}"></td></tr>
        `;
  }

  modal.style.display = "flex";
  modal.classList.add("is-active");
}

function closeEditModal() {
  const modal = document.getElementById("editModal");
  if (modal) {
    modal.style.display = "none";
    modal.classList.remove("is-active");
  }
}

function previewEditImage(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById("edit_img_preview").src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
  }
}

window.onclick = function (event) {
  const modal = document.getElementById("editModal");
  if (event.target == modal) {
    closeEditModal();
  }
};
