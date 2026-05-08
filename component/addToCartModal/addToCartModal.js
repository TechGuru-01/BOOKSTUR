function openCartModal(product) {
  const modal = document.getElementById("addToCartModal");
  const form = document.getElementById("addToCartForm");
  const availableInput = document.getElementById("stock_quantity");
  const sizeArea = document.getElementById("size-selection-area");
  const orderQtyInput = document.getElementById("order_quantity");

  if (!modal) return;

  if (form) form.reset();

  document.getElementById("cart_product_id").value = product.product_id;
  document.getElementById("cart_table").value = product.table;
  document.getElementById("cart_name").value = product.product_name;
  document.getElementById("cart_price").value = product.price;

  const imgHidden = document.getElementById("cart_product_image");
  const imgPreview = document.getElementById("cart_img_preview");

  if (imgHidden) imgHidden.value = product.product_image;
  if (imgPreview) {
    imgPreview.src = "../../src/uploads/products/" + product.product_image;
  }

  if (product.is_book || product.table === "books") {
    if (sizeArea) sizeArea.style.display = "none";

    const stock = parseInt(product.stock_quantity) || 0;
    availableInput.value = stock;
    availableInput.style.color = "black";

    orderQtyInput.max = stock;
    orderQtyInput.disabled = stock <= 0;
    orderQtyInput.value = stock > 0 ? 1 : 0;

    document.querySelectorAll('input[name="selected_size"]').forEach((r) => {
      r.required = false;
      r.checked = false;
    });
  } else {
    if (sizeArea) sizeArea.style.display = "block";

    availableInput.value = "Select a size";
    availableInput.style.color = "gray";
    orderQtyInput.disabled = true;

    document.querySelectorAll('input[name="selected_size"]').forEach((r) => {
      r.required = true;
    });

    const tiles = document.querySelectorAll(".size-tile");
    tiles.forEach((tile) => {
      const key = tile.getAttribute("data-size-key");
      const stockQty = parseInt(product[key]) || 0;
      const display = tile.querySelector(".stock-display");
      const radioInput = tile.querySelector("input[type='radio']");

      if (display) display.textContent = `(${stockQty})`;

      if (radioInput) {
        if (stockQty <= 0) {
          tile.classList.add("disabled-tile");
          radioInput.disabled = true;
        } else {
          tile.classList.remove("disabled-tile");
          radioInput.disabled = false;

          radioInput.onclick = function () {
            availableInput.value = stockQty;
            availableInput.style.color = "green";

            orderQtyInput.disabled = false;
            orderQtyInput.max = stockQty;
            orderQtyInput.value = 1;
          };
        }
      }
    });
  }

  modal.style.display = "flex";
}

document.getElementById("addToCartForm").onsubmit = function (e) {
  const table = document.getElementById("cart_table").value;
  const selectedSize = document.querySelector(
    'input[name="selected_size"]:checked',
  );
  if (table !== "books" && table !== "academic_tools") {
    if (!selectedSize) {
      alert("Please select a size first!");
      e.preventDefault();
      return false;
    }
  }
  return true;
};

function closeCartModal() {
  document.getElementById("addToCartModal").style.display = "none";
}
function closeCartModal() {
  document.getElementById("addToCartModal").style.display = "none";
}

document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("addToCartModal");
  window.onclick = function (event) {
    if (event.target == modal) {
      closeCartModal();
    }
  };

  const sizeTiles = document.querySelectorAll(".size-tile input");
  sizeTiles.forEach((radio) => {
    radio.addEventListener("change", function () {
      console.log("Selected Size:", this.value);
    });
  });

  const cartForm = document.getElementById("addToCartForm");
  if (cartForm) {
    cartForm.onsubmit = function (e) {
      const sizeRequired = document.querySelector(
        'input[name="selected_size"]',
      );

      if (
        sizeRequired &&
        !document.querySelector('input[name="selected_size"]:checked')
      ) {
        e.preventDefault();

        return false;
      }

      return true;
    };
  }
});
document
  .getElementById("addToCartForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch(this.action, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          Swal.fire({
            icon: "success",
            title: "Success!",
            text: data.msg,
            showConfirmButton: false,
            timer: 1500,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Failed",
            text: data.msg,
            showConfirmButton: false,
            timer: 2000,
          });
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        Swal.fire({
          icon: "error",
          title: "Connection Error",
          text: "Could not connect to the server. Check your action path.",
          showConfirmButton: false,
          timer: 2000,
        });
      });
  });
