<div class="toast" id="toast">
    <span class="material-icons-outlined">check_circle</span>
    <span id="toastMsg">Done!</span>
</div>

<div id="paymentOverlay" class="payment-overlay hidden">
    <div class="payment-sheet">
        <div class="payment-spinner-wrap" id="paymentSpinnerWrap">
            <div class="payment-spinner" id="paymentSpinner"></div>
        </div>
        <h2 class="payment-title" id="paymentTitle">Processing Payment</h2>
        <p class="payment-sub" id="paymentSub">Please wait, do not close this window...</p>
        <div class="payment-steps">
            <div class="payment-step" id="pstep1">
                <div class="payment-step-dot" id="pstep1dot">1</div>
                <span>Validating order details</span>
                <span class="material-icons-outlined payment-step-icon">fact_check</span>
            </div>
            <div class="payment-step" id="pstep2">
                <div class="payment-step-dot" id="pstep2dot">2</div>
                <span id="pstep2Label">Processing payment</span>
                <span class="material-icons-outlined payment-step-icon">payments</span>
            </div>
            <div class="payment-step" id="pstep3">
                <div class="payment-step-dot" id="pstep3dot">3</div>
                <span>Confirming with bookstore</span>
                <span class="material-icons-outlined payment-step-icon">storefront</span>
            </div>
        </div>
        <div class="payment-amount-chip">
            <span class="material-icons-outlined">payments</span>
            <span id="paymentChipMethod">GCash</span>
            <span class="chip-divider"></span>
            <strong id="paymentChipTotal">₱0.00</strong>
        </div>
    </div>
</div>

<div id="orderOverlay" class="order-overlay hidden">
    <div class="order-sheet">
        <div class="order-sheet-top">
            <div class="success-ring" style="width: 80px; height: 80px; border: 4px solid #27ae60; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; background-color: #f0fff4;">
                <div class="success-ring-inner">
                    <span class="material-icons-outlined success-icon" style="font-size: 48px; color: #27ae60; display: block;">
                        check
                    </span>
                </div>
            </div>
            <h2 class="order-success-title">Order Placed!</h2>
            <p class="order-success-sub">We've received your order. Please proceed to pickup.</p>
            <div class="order-id-chip" id="confirmOrderId">#SSCR-0000</div>
        </div>

        <div class="pickup-banner">
            <span class="material-icons-outlined pickup-banner-icon">storefront</span>
            <div>
                <div class="pickup-banner-title">Pickup Only</div>
                <div class="pickup-banner-sub">Delivery is not available at the moment. Claim your order at the SSCR Bookstore window during school hours.</div>
            </div>
        </div>

        <div class="order-tracker">
            <div class="tracker-step done" id="step-placed">
                <div class="tracker-dot">
                    <span class="material-icons-outlined">receipt_long</span>
                </div>
                <div class="tracker-info">
                    <div class="tracker-label">Order Placed</div>
                    <div class="tracker-time" id="trackerTime">—</div>
                </div>
            </div>
            <div class="tracker-line"></div>
            <div class="tracker-step active" id="step-processing">
                <div class="tracker-dot">
                    <span class="material-icons-outlined">inventory_2</span>
                </div>
                <div class="tracker-info">
                    <div class="tracker-label">Being Prepared</div>
                    <div class="tracker-time">Bookstore is processing your order</div>
                </div>
            </div>
            <div class="tracker-line"></div>
            <div class="tracker-step" id="step-ready">
                <div class="tracker-dot">
                    <span class="material-icons-outlined">store</span>
                </div>
                <div class="tracker-info">
                    <div class="tracker-label">Ready for Pickup</div>
                    <div class="tracker-time">You'll be notified when ready</div>
                </div>
            </div>
            <div class="tracker-line"></div>
            <div class="tracker-step" id="step-done">
                <div class="tracker-dot">
                    <span class="material-icons-outlined">check_circle</span>
                </div>
                <div class="tracker-info">
                    <div class="tracker-label">Completed</div>
                    <div class="tracker-time">Order claimed at bookstore</div>
                </div>
            </div>
        </div>

        <div class="confirm-summary">
            <div class="confirm-summary-title">Order Summary</div>
            <div id="confirmItemsList" class="confirm-items-list"></div>
            <div class="confirm-summary-divider"></div>
            <div class="confirm-row">
                <span>Payment Method</span>
                <span class="confirm-val" id="confirmPayment">—</span>
            </div>
            <div class="confirm-row">
                <span>Total Paid</span>
                <span class="confirm-val confirm-total" id="confirmTotal">₱0.00</span>
            </div>
        </div>

        <div class="order-actions">

                <a href="../../pages/profile/profile.php" class="btn-view-orders">
                    <span class="material-icons-outlined">receipt_long</span>
                    View My Orders
                </a>
            <a href="../../pages/dashboard/dashboard.php" class="btn-keep-shopping">
                <span class="material-icons-outlined">storefront</span>
                Continue Shopping
            </a>
        </div>
    </div>
</div>