function filterOrders() {
  // 1. Kunin ang search value
  const searchValue = document
    .getElementById("txSearch")
    .value.toLowerCase()
    .trim();

  // 2. Target elements (Table rows at Mobile cards)
  const tableRows = document.querySelectorAll(".tx-table tbody tr");
  const mobileCards = document.querySelectorAll(".tx-card-item");


  function applyFilter(elements) {
    let hasVisible = false;

    elements.forEach((el) => {
      const fullText = el.innerText.toLowerCase();
      const matchesSearch = !searchValue || fullText.includes(searchValue);

      if (matchesSearch) {
        el.style.display = "";
        hasVisible = true;
      } else {
        el.style.display = "none"; 
      }
    });
    return hasVisible;
  }

  const tableVisible = applyFilter(tableRows);
  const cardsVisible = applyFilter(mobileCards);
  const emptyState = document.querySelector(".tx-empty");
  if (emptyState) {
    if (!tableVisible && !cardsVisible) {
      emptyState.classList.remove("hidden");
    } else {
      emptyState.classList.add("hidden");
    }
  }
}
function viewOrderDetails(btn) {
  const row = btn.closest("tr");
  if (!row) return;

  let rawId = row.getAttribute("data-order");

  if (!rawId) {
    const idSpan = row.querySelector(".tx-order-id");
    rawId = idSpan ? idSpan.innerText : "";
  }

  const cleanId = rawId.replace("#SSCR-", "").trim();

  console.log("Attempting to fetch ID:", cleanId);

  if (!cleanId || cleanId === "0") {
    Swal.fire("Error", "Hindi mahanap ang Order ID sa row na ito.", "error");
    return;
  }


  Swal.fire({
    title: "Loading...",
    didOpen: () => {
      Swal.showLoading();
    },
  });

  fetch(`../../include/getOrder.php?order_id=${cleanId}`)
    .then((res) => res.json())
    .then((data) => {
      if (data.items && data.items.length > 0) {
        let itemsHtml =
          '<div style="max-height: 350px; overflow-y: auto; text-align: left; padding: 5px;">';

        data.items.forEach((item) => {
          const imgSrc = item.product_image
            ? `../../src/uploads/products/${item.product_image}`
            : "../../assets/img/no-image.png";
          itemsHtml += `
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px; padding: 10px; border: 1px solid #eee; border-radius: 8px;">
                            <img src="${imgSrc}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                            <div style="flex: 1;">
                                <div style="font-weight: bold; font-size: 14px;">${item.product_name}</div>
                                <div style="font-size: 12px; color: #666;">Qty: ${item.quantity} | ₱${parseFloat(item.price).toFixed(2)}</div>
                            </div>
                        </div>`;
        });

        itemsHtml += "</div>";
        itemsHtml += `<div style="margin-top: 15px; text-align: right; font-weight: bold; font-size: 16px; border-top: 1px solid #ddd; padding-top: 10px;">Total: ₱${parseFloat(data.total_amount).toFixed(2)}</div>`;

        Swal.fire({
          title: `Order #SSCR-${cleanId}`,
          html: itemsHtml,
          confirmButtonColor: "#dc1717",
        });
      } else {
        Swal.fire("Info", "Empty order details.", "info");
      }
    })
    .catch((err) => {
      console.error(err);
      Swal.fire("Error", "Failed to fetch data. Check network tab.", "error");
    });
}
function updateStatus(selectElement, orderId) {
  const newStatus = selectElement.value;

  fetch("../../include/transactionStatusFunction.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `order_id=${orderId}&status=${newStatus}`,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok: " + response.statusText);
      }
      return response.json();
    })
    .then((data) => {
      if (data.success) {
        location.reload();
      } else {
        alert("Error: " + data.message);
      }
    })
    .catch((error) => {
      console.error("Error Details:", error);
      alert("Hindi ma-update ang status. Pakitingnan ang console (F12).");
    });
}
function viewOrderDetails(orderId) {
  Swal.fire({
    title: "Fetching details...",
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    },
  });

  fetch(`../../include/get_order_items.php?order_id=${orderId}`)
    .then((res) => {
      if (!res.ok) throw new Error("Network response was not ok");
      return res.json();
    })
    .then((data) => {
      let itemsHtml = `
                <div style="max-height: 400px; overflow-y: auto; padding: 10px; scrollbar-width: thin;">
                    <div style="text-align: left;">
            `;

      if (!data.items || data.items.length === 0) {
        itemsHtml += `<p style="text-align:center; color:#888;">No items found for this order.</p>`;
      } else {
        data.items.forEach((item) => {
          const imgSrc = item.product_image
            ? `../../src/uploads/products/${item.product_image}`
            : "../../assets/img/no-image.png";

          itemsHtml += `
                        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px; padding: 12px; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #f0f0f0;">
                            
                            <!-- Product Image -->
                            <div style="width: 60px; height: 60px; flex-shrink: 0; background-color: #f8f9fa; border-radius: 8px; overflow: hidden; border: 1px solid #eee;">
                                <img src="${imgSrc}" 
                                     alt="${item.product_name}"
                                     style="width: 100%; height: 100%; object-fit: cover;"
                                     onerror="this.src='../../assets/img/no-image.png'">
                            </div>

                            <!-- Product Details -->
                            <div style="flex: 1; display: flex; flex-direction: column; gap: 2px;">
                                <div style="font-weight: 600; font-size: 14px; color: #2d3436; line-height: 1.3;">
                                    ${item.product_name}
                                </div>
                                
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 5px;">
                                    <div style="font-size: 12px; color: #636e72; background: #f1f2f6; padding: 2px 8px; border-radius: 4px;">
                                        Qty: <span style="font-weight: 700;">${item.quantity}</span>
                                    </div>
                                    <div style="font-size: 14px; font-weight: 700; color: #dc1717;">
                                        ₱${parseFloat(item.price).toLocaleString(undefined, { minimumFractionDigits: 2 })}
                                    </div>
                                </div>
                            </div>
                        </div>`;
        });
      }

      itemsHtml += `
                    </div>
                </div>
                <!-- Subtotal/Total Section -->
                <div style="margin-top: 15px; padding-top: 15px; border-top: 2px dashed #eee; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 600; color: #636e72;">Order Total:</span>
                    <span style="font-size: 18px; font-weight: 800; color: #2d3436;">₱${parseFloat(data.total_amount || 0).toLocaleString(undefined, { minimumFractionDigits: 2 })}</span>
                </div>
            `;
      Swal.fire({
        title: `<span style="font-size: 18px;">Order #SSCR-${orderId}</span>`,
        html: itemsHtml,
        width: "500px",
        confirmButtonColor: "#dc1717",
        confirmButtonText: "Close",
        showCloseButton: true,
        customClass: {
          popup: "rounded-modal",
        },
      });
    })
    .catch((err) => {
      console.error("Error:", err);
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Something went wrong while fetching order details.",
        confirmButtonColor: "#dc1717",
      });
    });
}
