function viewOrderDetails(orderId) {
  fetch(`../../include/getOrder.php?order_id=${orderId}`)
    .then((res) => res.json())
    .then((data) => {
      let itemsHtml = '<div style="text-align: left;">';
      data.items.forEach((item) => {
        itemsHtml += `
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                    <img src="../../src/uploads/products/${item.product_image}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                    <div style="flex: 1;">
                        <div style="font-weight: bold; font-size: 14px;">${item.product_name}</div>
                        <div style="font-size: 12px; color: #666;">Qty: ${item.quantity} x ₱${parseFloat(item.price).toFixed(2)}</div>
                    </div>
                </div>`;
      });
      itemsHtml += "</div>";

      Swal.fire({
        title: `Order Details #SSCR-${orderId}`,
        html: itemsHtml,
        confirmButtonColor: "#dc1717",
        confirmButtonText: "Close",
      });
    });
}
document.addEventListener("DOMContentLoaded", function () {
  const hash = window.location.hash;
  if (hash === "#transactions-tab") {
    const transactionTab = document.querySelector(
      '[data-bs-target="#transactions-tab"]',
    );
    if (transactionTab) {
      transactionTab.click();
    }
  }
});
