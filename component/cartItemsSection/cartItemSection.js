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

            <button type="button" class="cart-remove-btn" onclick="removeItem(${item.cart_id})">
                <span class="material-icons-outlined">close</span>
            </button>
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

function removeItem(cartId) {
  const formData = new FormData();
  formData.append("action", "delete");
  formData.append("delete_id", cartId);

  fetch("cart.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      return response.text().then((text) => {
        try {
          return JSON.parse(text);
        } catch (err) {
          console.error("PHP Error Detected:", text);
          throw new Error("Invalid JSON response from server");
        }
      });
    })
    .then((data) => {
      if (data.status === "success") {
        Swal.fire({
          toast: true,
          position: "top-end",
          icon: "success",
          title: data.msg,
          showConfirmButton: false,
          timer: 2000,
        });
        document.getElementById(`item-${cartId}`)?.remove();
      } else {
        alert(data.msg);
      }
    })
    .catch((error) => console.error("Fetch Error:", error));
}
function clearCart() {
  Swal.fire({
    title: "Clear Cart?",
    text: "Are you sure you want to remove all items from your cart?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#dc3545",
    cancelButtonColor: "#28a745",
    confirmButtonText: "Clear Cart",
    cancelButtonText: "keep Items",
  }).then((result) => {
    if (result.isConfirmed) {
      const formData = new FormData();
      formData.append("action", "clear_all");

      fetch("cart.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status === "success") {
            document.getElementById("cart-item").innerHTML = "";
            document.getElementById("emptyCart").style.display = "flex";
            document.getElementById("itemCountBadge").textContent = "0";

            const Toast = Swal.mixin({
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 2500,
              timerProgressBar: true,
              background: "#fff",
              color: "#28a745",
              iconColor: "#28a745",
            });

            Toast.fire({
              icon: "success",
              title: "Cart cleared successfully",
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: data.msg,
              confirmButtonColor: "#dc3545",
            });
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          Swal.fire({
            icon: "error",
            title: "Server Error",
            text: "Hindi ma-proseso ang request.",
            confirmButtonColor: "#dc3545",
          });
        });
    }
  });
}
