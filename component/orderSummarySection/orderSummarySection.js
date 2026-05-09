function updateSummary() {
  let subtotal = 0;
  let count = 0;

  const selectedItems = document.querySelectorAll(".item-checkbox:checked");

  selectedItems.forEach((checkbox) => {
    const price = parseFloat(checkbox.getAttribute("data-price"));
    const qty = parseInt(checkbox.getAttribute("data-qty"));
    subtotal += price * qty;
    count += qty;
  });

  document.getElementById("summaryItemCount").textContent = count;
  document.getElementById("summarySubtotal").textContent =
    `₱${subtotal.toFixed(2)}`;
  document.getElementById("summaryTotal").textContent =
    `₱${subtotal.toFixed(2)}`;

  const checkoutBtn = document.getElementById("checkoutBtn");
  if (count > 0) {
    checkoutBtn.disabled = false;
    checkoutBtn.innerHTML = `<span class="material-icons-outlined">shopping_bag</span> Place Order`;
  } else {
    checkoutBtn.disabled = true;
    checkoutBtn.innerHTML = `<span class="material-icons-outlined">block</span> Select Items First`;
  }
}
function proceedCheckout() {
  const selectedCheckboxes = document.querySelectorAll(
    ".item-checkbox:checked",
  );
  if (selectedCheckboxes.length === 0) {
    Swal.fire("Oops!", "Please select items to buy.", "warning");
    return;
  }

  const selectedCartIds = Array.from(selectedCheckboxes).map((cb) => cb.value);
  const paymentMethod = document.querySelector(
    'input[name="payment"]:checked',
  ).value;
  const totalAmount = document.getElementById("summaryTotal").textContent;
  const notes = document.getElementById("orderNotes").value;

  const paymentOverlay = document.getElementById("paymentOverlay");
  paymentOverlay.classList.remove("hidden");

  document.getElementById("paymentChipMethod").textContent = paymentMethod;
  document.getElementById("paymentChipTotal").textContent = totalAmount;

  const steps = [
    { dot: "pstep1dot", item: "pstep1" },
    { dot: "pstep2dot", item: "pstep2" },
    { dot: "pstep3dot", item: "pstep3" },
  ];

  let currentStep = 0;

  const formData = new FormData();
  formData.append("action", "place_order");
  formData.append("cart_ids", JSON.stringify(selectedCartIds));
  formData.append("payment_method", paymentMethod);
  formData.append("notes", notes);

  fetch("cart.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        const interval = setInterval(() => {
          if (currentStep < steps.length) {
            const step = steps[currentStep];
            document.getElementById(step.item).classList.add("active");
            document.getElementById(step.dot).innerHTML = "check";
            document.getElementById(step.dot).style.background = "#28a745";
            currentStep++;
          } else {
            clearInterval(interval);
            showSuccessOverlay(data.order_id, totalAmount, paymentMethod);
          }
        }, 800);
      } else {
        paymentOverlay.classList.add("hidden");
        Swal.fire("Error", data.msg, "error");
      }
    })
    .catch((err) => {
      paymentOverlay.classList.add("hidden");
      console.error(err);
    });
}

function showSuccessOverlay(orderId, total, method) {
  document.getElementById("paymentOverlay").classList.add("hidden");

  const orderOverlay = document.getElementById("orderOverlay");
  orderOverlay.classList.remove("hidden");

  document.getElementById("confirmOrderId").textContent = `#ORD-${orderId}`;
  document.getElementById("confirmPayment").textContent = method;
  document.getElementById("confirmTotal").textContent = total;
  document.getElementById("trackerTime").textContent =
    new Date().toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });

  document.getElementById("cart-item").innerHTML = "";
  document.getElementById("emptyCart").style.display = "flex";
  document.getElementById("itemCountBadge").textContent = "0";
}
