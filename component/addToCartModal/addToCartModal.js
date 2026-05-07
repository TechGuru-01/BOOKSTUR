function openAddToCartModal(product) {
  const modal = document.getElementById("addToCartModal");

  // Mapping ng ID
  document.getElementById("cart_product_id").value =
    product.product_id || product.id;

  const tableInput =
    document.getElementById("cart_producttype") ||
    document.getElementById("cart_table");
  if (tableInput) {
    tableInput.value = product.table;
  }

  // Populate fields (readonly sa HTML pero kailangan pa rin lagyan ng value)
  document.getElementById("cart_name").value = product.product_name;
  document.getElementById("cart_price").value = product.price;

  // Kung may category name field ka para sa display
  if (document.getElementById("cart_category_name")) {
    document.getElementById("cart_category_name").value =
      product.category_name || "";
  }
  document.getElementById("cart_category_id").value = product.category_id;
  document.getElementById("cart_notes").value = ""; // I-clear ang notes tuwing magbubukas

  const stockTableBody = document.getElementById("cartStockTableBody");

  // Logic para sa quantity/sizes
  if (
    product.is_book ||
    product.table === "books" ||
    product.table === "academic_tools"
  ) {
    // Single quantity input para sa libro/tools
    stockTableBody.innerHTML = `
      <tr>
        <td><strong>Quantity to Order</strong></td>
        <td><input type="number" name="quantity" id="cart_qty" class="edit-input-field" min="1" value="1"></td>
      </tr>
    `;
  } else {
    // Size selection para sa apparel/others
    stockTableBody.innerHTML = `
      <tr><td>Small</td><td><input type="number" name="qty[S]" id="cart_qty_S" class="edit-input-field" min="0" value="0"></td></tr>
      <tr><td>Medium</td><td><input type="number" name="qty[M]" id="cart_qty_M" class="edit-input-field" min="0" value="0"></td></tr>
      <tr><td>Large</td><td><input type="number" name="qty[L]" id="cart_qty_L" class="edit-input-field" min="0" value="0"></td></tr>
      <tr><td>XL</td><td><input type="number" name="qty[XL]" id="cart_qty_XL" class="edit-input-field" min="0" value="0"></td></tr>
    `;
  }

  // Image Preview
  const preview = document.getElementById("cart_img_preview");
  const path = "../../src/uploads/products/";
  const imgName = product.product_image || product.img;
  preview.src = imgName ? path + imgName : "../../src/placeholder.jpg";

  modal.classList.add("is-active");
}

function closeCartModal() {
  document.getElementById("addToCartModal").classList.remove("is-active");
}

// Isara ang modal kapag clinic sa labas ng box
window.onclick = function (event) {
  const modal = document.getElementById("addToCartModal");
  if (event.target == modal) {
    closeCartModal();
  }
};
