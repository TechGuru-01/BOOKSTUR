function viewOrderDetails(orderId) {
  fetch(`../../include/getOrder.php?order_id=${orderId}`)
    .then((res) => res.json())
    .then((data) => {
      let itemsHtml = '<div style="text-align: left;">';
      data.items.forEach((item) => {
        itemsHtml += `
               <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px; padding: 12px; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #f0f0f0; transition: transform 0.2s ease;">
    
                <!-- Product Image with container for consistent sizing -->
                <div style="width: 64px; height: 64px; flex-shrink: 0; background-color: #f8f9fa; border-radius: 8px; overflow: hidden; border: 1px solid #eee;">
                    <img src="../../src/uploads/products/${item.product_image}" 
                        alt="${item.product_name}"
                        style="width: 100%; height: 100%; object-fit: cover;">
                </div>

                <!-- Product Details -->
                <div style="flex: 1; display: flex; flex-direction: column; gap: 4px;">
                    <div style="font-weight: 600; font-size: 15px; color: #2d3436; line-height: 1.2; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        ${item.product_name}
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 2px;">
                        <div style="font-size: 13px; color: #888; background: #f1f2f6; padding: 2px 8px; border-radius: 4px;">
                            Qty: <span style="color: #2d3436; font-weight: 600;">${item.quantity}</span>
                        </div>
                        <div style="font-size: 14px; font-weight: 700; color: #e67e22;">
                            ₱${parseFloat(item.price).toFixed(2)}
                        </div>
                    </div>
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
