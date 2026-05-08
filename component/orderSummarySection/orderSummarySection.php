<div class="cart-card">
    <div class="cart-card-header">
        <span class="cart-card-title">
            <span class="material-icons-outlined">receipt_long</span>
            Order Summary
        </span>
    </div>

    <div class="summary-row">
        <span class="summary-label">Subtotal (<span id="summaryItemCount">0</span> items)</span>
        <span class="summary-value" id="summarySubtotal">₱0.00</span>
    </div>
    <div class="summary-row" id="discountRow" style="display:none;">
        <span class="summary-label summary-label-green">
            Discount <span class="discount-badge" id="discountBadge"></span>
        </span>
        <span class="summary-value summary-value-green" id="discountValue">−₱0.00</span>
    </div>
    <div class="summary-row">
        <span class="summary-label">Pickup</span>
        <span class="summary-value summary-value-green">FREE</span>
    </div>

    <div class="summary-total-row">
        <span class="summary-total-label">Total</span>
        <span class="summary-total-value" id="summaryTotal">₱0.00</span>
    </div>

    <div class="payment-options">
        <p class="payment-options-label">Payment Method</p>

        <label class="payment-option selected" onclick="selectPayment(this)">
            <input type="radio" name="payment" value="GCash" checked>
            <div>
                <div class="payment-option-label">GCash</div>
                <div class="payment-option-sub">Pay via GCash mobile wallet</div>
            </div>
            <div class="payment-icon payment-icon-yellow">
                <span class="material-icons-outlined">phone_iphone</span>
            </div>
        </label>

        <label class="payment-option" onclick="selectPayment(this)">
            <input type="radio" name="payment" value="Over the Counter">
            <div>
                <div class="payment-option-label">Over the Counter</div>
                <div class="payment-option-sub">Pay at the bookstore window</div>
            </div>
            <div class="payment-icon payment-icon-green">
                <span class="material-icons-outlined">store</span>
            </div>
        </label>
    </div>

    <div class="checkout-wrap">
        <button class="checkout-btn" id="checkoutBtn" onclick="proceedCheckout()" disabled>
            <span class="material-icons-outlined">lock</span>
            Place Order
        </button>
        <a href="../../pages/dashboard/dashboard.php" class="continue-link">
            <span class="material-icons-outlined">arrow_back</span>
            Continue Shopping
        </a>
    </div>
</div>

<div class="cart-card trust-card">
    <div class="trust-list">
        <div class="trust-item">
            <span class="material-icons-outlined trust-icon trust-icon-green">verified</span>
            Official SSCR Bookstore — authentic items only
        </div>
        <div class="trust-item">
            <span class="material-icons-outlined trust-icon trust-icon-blue">local_shipping</span>
            Pickup available at the bookstore window
        </div>
        <div class="trust-item">
            <span class="material-icons-outlined trust-icon trust-icon-yellow">support_agent</span>
            Need help? Visit the bookstore during school hours
        </div>
    </div>
</div>