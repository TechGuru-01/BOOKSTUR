function openCartModal(product) {
  const modal = document.getElementById("addToCartModal");
  const form = document.getElementById("addToCartForm");

  if (!modal) {
    console.error("Modal not found!");
    return;
  }


  if (form) form.reset();
  document.getElementById("cart_product_id").value = product.product_id;
  document.getElementById("cart_table").value = product.table;

  document.getElementById("cart_name").value = product.product_name;
  document.getElementById("cart_price").value = product.price;

  const imgPreview = document.getElementById("cart_img_preview");
  if (imgPreview) {
    imgPreview.src = "../../src/uploads/products/" + product.product_image;
  }

  const tiles = document.querySelectorAll(".size-tile");

  tiles.forEach((tile) => {
    const key = tile.getAttribute("data-size-key"); 
    const stockQty = product[key] || 0; 
    const display =
      tile.querySelector(".stock-display") ||
      tile.querySelector(".stock-count");
    const radioInput = tile.querySelector("input[type='radio']");

    if (display) {
      display.textContent = `(${stockQty})`;
    }

    if (radioInput) {
      if (parseInt(stockQty) <= 0) {
        tile.classList.add("disabled-tile");
        radioInput.disabled = true;
        if (display) display.textContent = "(0)";
      } else {
        tile.classList.remove("disabled-tile");
        radioInput.disabled = false;
      }
    }
  });

  modal.style.display = "flex";
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
        alert("Please select a size first!");
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
