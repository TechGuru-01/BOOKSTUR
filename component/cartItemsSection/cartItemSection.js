async function loadCartItems() {
  const listEl = document.getElementById("cart-item");
  const emptyEl = document.getElementById("emptyCart");
  const badge = document.getElementById("itemCountBadge");

  try {
    const response = await fetch("cart.php?action=fetch");
    const data = await response.json();

    if (data.success && data.items.length > 0) {
      if (emptyEl) emptyEl.classList.add("hidden");
      listEl.innerHTML = "";
      badge.textContent = data.items.length;

      data.items.forEach((item) => {
        const div = document.createElement("div");
        div.className = "cart-item";
        div.id = `item-${item.cart_id}`;

        div.innerHTML = `
            <!-- Checkbox para sa Selection -->
            <div class="cart-select-wrapper">
                <input type="checkbox" 
                      class="item-checkbox" 
                      value="${item.cart_id}" 
                      data-price="${item.price}" 
                      data-qty="${item.quantity}"
                      onchange="updateSummary()" 
                      >
            </div>

            <div class="cart-item-image">
                <img src="../../src/uploads/products/${item.product_image}" 
                    alt="${item.product_name}" 
                    onerror="this.onerror=null; this.src='/src/uploads/products/default.png';" 
                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
            </div>

            <div class="cart-item-info">
                <div class="cart-item-name"><strong>${item.product_name}</strong></div>
                <div class="cart-item-price">₱${parseFloat(item.price).toFixed(2)}</div>
            </div>
            
            <div class="qty-control">
                <span class="qty-value">${item.quantity}</span>
            </div>

            <div class="cart-item-subtotal">
                ₱${(parseFloat(item.price) * parseInt(item.quantity)).toFixed(2)}
            </div>

        `;
        listEl.appendChild(div);
      });

      const checkoutBtn = document.getElementById("checkoutBtn");
      if (checkoutBtn) checkoutBtn.disabled = false;
    } else {
      if (emptyEl) emptyEl.classList.remove("hidden");
      listEl.innerHTML = "";
      badge.textContent = "0";
    }
  } catch (error) {
    console.error("Cart Loading Error:", error);
  }
}

document.addEventListener("DOMContentLoaded", loadCartItems);
